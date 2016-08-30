<?php
/* 邏輯 - 人員區域設定 */
namespace App\Services\Work;

use App\Repository\User as Repository;
use App\Repository\StationArea as AreaRepository;
use App\Helpers\ValidatorFile;
use Website;
use Validator;
use Config;
use Lang;
use Auth;
use Excel;

class StaffAreaService
{
    protected $oModel;
    protected $AreaModel;

    public function __construct(Repository $Model, AreaRepository $AreaModel)
    {
        $this->oModel = $Model;
        $this->AreaModel = $AreaModel;
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
        $aArea = $this->AreaModel->getArea();
        /* 取資料 */
        $aHandle = Website::handleGet([
            'get'     => $aParam,
            'format'  => ['acc' => Config::get('validator.acc')],
            'replace' => ['acc' => 'username']
        ]);
        $aInfo = $this->oModel->getList($aHandle['where']);
        foreach ($aInfo as $iKey => $aVal) {
            $aInfo[$iKey]['area'] = (isset($aVal['area']) && is_array($aVal['area'])) ? $aVal['area'] : array();
            $aInfo[$iKey]['area_name'] = implode(',', $aVal['area']);
        }

        return ['info' => $aInfo, 'get' => $aHandle['get'], 'area' => $aArea];
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
            $aFormat = ['id' => Config::get('validator.id')];

            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            $aArea = $this->AreaModel->getArea()->toArray();
            $aSaveArea = (isset($aParam['item'])) ? explode(',', $aParam['item']) : array();
            foreach ($aSaveArea as $iKey => $sVal) {
                if (!in_array($sVal, $aArea)) {
                    unset($aArea);
                }
            }
            asort($aSaveArea);
            /* 寫入資料 */
            $aSaveParam = array(
                'area'        => $aSaveArea,
                'modify_date' => time(),
                'modify_user' => Auth::user()->_id
            );
            $this->oModel->updateData($aParam['id'], array_merge(['area' => $aSaveArea], Website::getSaveInfo('edit')));
            return [
                'result'   => true,
                'message'  => Lang::get('back.s_edit_data'),
                'redirect' => $aParam['default_url']
            ];
        } catch (\Exception $e) {
            return array('result' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * 下載資料匯入範例
     */
    public function download()
    {
        Excel::create(Lang::get('website.data_example'), function($excel) {
            $excel->sheet(Lang::get('website.data_example'), function($sheet) {
                $sheet->prependRow(1, [Lang::get('website.staff_no'), Lang::get('website.staff_area')]);
                $sheet->row(2, ['admin', 'A,B,C']);
                $sheet->row(3, ['104001', 'A,B']);
                $sheet->row(4, ['104002', 'A,B']);
                $sheet->row(5, ['104003', '']);
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
            $aArea = $this->AreaModel->getArea()->toArray();
            $aTemp = [];
            foreach ($aExcel as $aVal) {
                if ($aVal[0] != '' && count(Validator::make(['username' => $aVal[0]], ['username' => Config::get('validator.acc')])->errors()->all()) == 0) {
                    $aSaveArea = (isset($aVal[1])) ? explode(',', $aVal[1]) : array();
                    foreach ($aSaveArea as $iKey => $sVal) {
                        if (!in_array($sVal, $aArea)) {
                            unset($aArea);
                        }
                    }
                    asort($aSaveArea);
                    $aTemp[$aVal[0]] = $aSaveArea;
                }
            }
            /* 開始更新資料 */
            foreach ($aTemp as $sUsername => $aArea) {
                $this->oModel->importUpdate(array_merge(['area' => $aArea], Website::getSaveInfo('edit')), $sUsername);
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
