<?php
/* 邏輯 - 工作區域設定 */
namespace App\Services\Work;

use App\Repository\Station as Repository;
use App\Repository\StationArea as AreaRepository;
use Validator;
use Auth;
use Config;
use Lang;
use Website;

class AreaService
{
    protected $oModel;
    protected $oAreaModel;

    public function __construct(Repository $Model, AreaRepository $AreaModel)
    {
        $this->oModel = $Model;
        $this->oAreaModel = $AreaModel;
    }

    /**
     * 列表頁面
     * @param  \Illuminate\Http\Request  $request
     * @return array         [array('info' => '')]
     */
    public function getList(array $aParam = array())
    {
        /* Set */
        $aInfo = [];
        $aTemp = $this->getArea();
        $aArea = $aTemp['area'];
        $aAreaStaff = $aTemp['staff'];
        $aCity = Auth::user()->city;
        /* 取資料 */
        $aHandle = Website::handleGet([
            'get'     => $aParam,
            'format'  => [
                'c' => Config::get('validator.city').implode('","', $aCity).'"',
                'a' => Config::get('validator.station_area').'|in:"'.implode('","', $aArea).'"'
            ],
            'replace' => ['c' => 'city', 'a' => 'set_area'],
            'city'    => $aCity
        ]);
        $aInfo = $this->oModel->getList($aHandle['where']);
        foreach ($aInfo as $iKey => $aVal) {
            $aInfo[$iKey]['modify_date'] = date('Y-m-d H:i:s', $aVal['modify_date']);
            $aInfo[$iKey]['staff'] = (isset($aAreaStaff[$aVal['set_area']]) ) ? $aAreaStaff[$aVal['set_area']] : '' ;
        }
        /* 回傳 */
        return ['info' => $aInfo, 'get' => $aHandle['get'], 'area' => $aArea, 'city' => $aCity];
    }

    /**
     * 新增資料
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function add(array $aParam = array())
    {
        try {
            /* 驗證資料 */
            if (count(Validator::make($aParam, ['area_name' => Config::get('validator.station_area')])->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            $aParam['id'] = '';
            if ($this->oAreaModel->checkSame($aParam) > 0) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }
            /* 寫入資料 */
            $this->oAreaModel->create(array_merge(['area_name' => $aParam['area_name']], Website::getSaveInfo()));
            /* 回傳 */
            return [
                'result'   => true,
                'message'  => Lang::get('back.s_add_data'),
                'redirect' => Website::getRedirect($aParam, $aParam['default_url'])
            ];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
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
            if (count(Validator::make($aParam, ['item' => 'required'])->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            $aArea = $this->oAreaModel->getArea()->toArray();
            foreach (json_decode($aParam['item']) as $sID => $aVal) {
                $this->oModel->updateData($sID, array_merge([
                    'set_rope' => (int) $aVal->rope,
                    'set_area' => (in_array($aVal->area, $aArea)) ? $aVal->area : ''
                ], Website::getSaveInfo('edit')));
            }
            return [
                'result'   => true,
                'message'  => Lang::get('back.s_edit_data'),
                'redirect' => Website::getRedirect($aParam, $aParam['default_url'])
            ];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 取得區域資料
     * @return array
     */
    private function getArea()
    {
        $aArea = $aAreaStaff = [];
        $aTemp = $this->oAreaModel->getAll()->toArray();
        foreach ($aTemp as $aVal) {
            $aArea[] = $aVal['area_name'];
            $aAreaStaff[$aVal['area_name']] = (isset($aVal['staff'])) ? implode(',', $aVal['staff']) : '';
        }
        return ['area' => $aArea, 'staff' => $aAreaStaff];
    }

}
