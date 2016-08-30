<?php
/* 邏輯 - 例行派工設定 */
namespace App\Services\Work;

use App\Repository\User as Repository;
use App\Repository\UsersDept as DeptRepository;
use App\Helpers\ValidatorFile;
use Validator;
use Website;
use Config;
use Lang;
use Auth;
use Excel;

class AllocationService
{
    protected $oModel;
    protected $oDeptModel;

    public function __construct(Repository $Model, DeptRepository $DeptModel)
    {
        $this->oModel = $Model;
        $this->oDeptModel = $DeptModel;
    }

    /**
     * 列表頁面
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getList(array $aParam = array())
    {
        /* Set */
        $aInfo = [];
        $aCity = Auth::user()->city;
        /* 取資料 */
        $aHandle = Website::handleGet([
            'get'     => $aParam,
            'format'  => [
                'no' => Config::get('validator.acc'),
                'c'  => Config::get('validator.city').implode('","', $aCity).'"'
            ],
            'replace' => ['no' => 'username', 'c' => 'city'],
            'city'    => $aCity
        ]);
        $aInfo = $this->oModel->getList($aHandle['where']);
        foreach ($aInfo as $iKey => $aVal) {
            $aInfo[$iKey]['dept_info'] = '台北市 > 大安區 > 維修組 > 維修工程師';
            $aInfo[$iKey]['work_keynote'] = (isset($aVal['work_keynote'])) ? implode('/', $aVal['work_keynote']) : '';
        }
        return array('info' => $aInfo, 'get' => $aHandle['get']);
    }

    /**
     * 修改資料
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function edit(array $aParam = array())
    {
        try {
            /* 驗證資料 */
            if (count(Validator::make($aParam, ['id' => Config::get('validator.id')])->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }

            /* 寫入資料 */
            $this->oModel->updateData($aParam['id'], array_merge([
                'work_notice' => $aParam['work_notice'],
                'work_keynote' => (isset($aParam['work_keynote'])) ? explode(',', $aParam['work_keynote']) : array(),
            ], Website::getSaveInfo('edit')));
            /* 回傳 */
            return [
                'result'   => true,
                'message'  => Lang::get('back.s_edit_data'),
                'redirect' => $aParam['default_url']
            ];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 清除資料
     * @param  string $id
     * @return array
     */
    public function clear($id)
    {
        try {
            /* 驗證資料 */
            if (count(Validator::make(['id' => $id], ['id' => Config::get('validator.id')])->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 清除資料 */
            $this->oModel->updateData($id, array_merge([
                'work_notice'  => '',
                'work_keynote' => array()
            ], Website::getSaveInfo('edit')));
            /* 回傳 */
            return ['result' => true, 'message' => Lang::get('back.s_clear_data')];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 清除多筆資料
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function clearMulti(array $aParam = array())
    {
        try {
            /* 驗證資料 */
            foreach ($aParam['clear'] as $id) {
                if (count(Validator::make(['id' => $id], ['id' => Config::get('validator.id')])->errors()->all()) > 0) {
                    throw new \Exception(Lang::get('back.f_data_format'));
                }
            }
            /* 清除資料 */
            $this->oModel->clearAllocationMulti($aParam['clear'], array_merge([
                'work_notice'  => '',
                'work_keynote' => array()
            ], Website::getSaveInfo('edit')));

            /* 回傳 */
            return [
                'result'   => true,
                'message'  => Lang::get('back.s_clear_data'),
                'redirect' => Website::getRedirect($aParam, $aParam['default_url'])
            ];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 下載資料匯入範例
     */
    public function download()
    {
        Excel::create(Lang::get('website.data_example'), function($excel) {
            $excel->sheet(Lang::get('website.data_example'), function($sheet) {
                $sheet->prependRow(1, [Lang::get('website.staff_no'), Lang::get('website.work_notice'), Lang::get('website.work_keynote')]);
                $sheet->row(2, ['admin', '開車回來', '市政府,火車站']);
                $sheet->setFontSize(12)->setAutoSize(true);
            });
        })->download('xls');
    }

    /**
     * 匯入資料
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function import(array $aParam = array())
    {
        try {
            /* 驗證資料 */
            if (count(Validator::make($aParam, ['upload_excel' => Config::get('validator.excel')])->errors()->all()) > 0 ||
                ValidatorFile::checkExcel($aParam['upload_excel']) != true ||
                $aParam['upload_excel']->isValid() != true) {
                throw new \Exception(Lang::get('back.f_import_format'));
            }
            $oExcel = Excel::load($aParam['upload_excel']);
            $aExcel = $oExcel->getSheet(0)->toArray();
            unset($aExcel[0]);
            /* 整理要更新的資料 */
            $aTemp = [];
            foreach ($aExcel as $aVal) {
                if ($aVal[0] != '' && count(Validator::make(['username' => $aVal[0]], ['username' => Config::get('validator.acc')])->errors()->all()) == 0) {
                    $aTemp[$aVal[0]] = ['note' => $aVal[1], 'keynote' => (isset($aVal[2])) ? explode(',', $aVal[2]) : array() ];
                }
            }
            /* 開始更新資料 */
            foreach ($aTemp as $sUsername => $aVal) {
                $this->oModel->importUpdate(array_merge(['work_notice' => $aVal['note'], 'work_keynote' => $aVal['keynote']], Website::getSaveInfo('edit')), $sUsername);
            }
            /* 回傳 */
            return [
                'result'   => true,
                'message'  => Lang::get('back.s_import_data'),
                'redirect' => $aParam['default_url']
            ];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }
}
