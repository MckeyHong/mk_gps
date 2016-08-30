<?php
/* 邏輯 - 車輛配置設定 */
namespace App\Services\Gps;

use App\Repository\Car as Repository;
use App\Repository\CarBrand as CarBrandRepository;
use App\Repository\CarType as CarTypeRepository;
use App\Repository\Gps as GPSRepository;
use Validator;
use Website;
use Config;
use Lang;
use Auth;

class CarService
{

    protected $oModel;
    protected $oBrandModel;
    protected $oTypeModel;
    protected $oGPSModel;

    public function __construct(Repository $Model, GPSRepository $GPSModel, CarBrandRepository $BrandModel, CarTypeRepository $TypeModel)
    {
        $this->oModel = $Model;
        $this->oBrandModel = $BrandModel;
        $this->oTypeModel = $TypeModel;
        $this->oGPSModel = $GPSModel;
    }

    /**
     * 列表頁面
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getList(array $aParam = array())
    {
        /* Set */
        $aInfo = $aGPSList = $aGPSAdd = [];
        $aCity = Auth::user()->city;
        $aCarBrand = $this->oBrandModel->getBrand();
        $aCarType = $this->oTypeModel->getType();
        $aTemp = $this->oGPSModel->getGPS();
        foreach ($aTemp as $aVal) {
            if(isset($aVal['car_id']) && $aVal['car_id'] != '') {
                $aGPSList[$aVal['_id']] = $aVal;
            } else {
                $aGPSAdd[$aVal['_id']] = $aVal;
            }

        }
        /* 取資料 */
        $aHandle = Website::handleGet([
            'get'     => $aParam,
            'format'  => [
                'c'    => Config::get('validator.city').implode('","', $aCity).'"',
                'gps'  => Config::get('validator.gps_no'),
                'car'  => Config::get('validator.car_no'),
                'type' => Config::get('validator.id')
            ],
            'replace' => ['c' => 'city', 'car' => 'car_no', 'type' => 'car_type_id', 'gps' => 'gps_no'],
            'city'    => $aCity
        ]);
        $aInfo = $this->oModel->getList($aHandle['where']);
        foreach ($aInfo as $iKey => $aVal) {
            $aInfo[$iKey]['gps_no'] = $aInfo[$iKey]['cellphone'] = $aInfo[$iKey]['cellphone_provider'] = $aInfo[$iKey]['city'] = '';
            if(isset($aGPSList[$aVal['gps_id']])) {
                $aTemp = $aGPSList[$aVal['gps_id']];
                $aInfo[$iKey]['gps_no'] = $aTemp['gps_no'];
                $aInfo[$iKey]['cellphone'] = $aTemp['cellphone'];
                $aInfo[$iKey]['cellphone_provider'] = $aTemp['cellphone_provider'];
                $aInfo[$iKey]['city'] = $aTemp['city'];
            }
            $aInfo[$iKey]['car_type'] = (isset($aCarType[$aVal['car_type_id']])) ? $aCarType[$aVal['car_type_id']] : '';
        }
        return ['info' => $aInfo, 'get' => $aHandle['get'], 'city' => $aCity, 'car_type' => $aCarType, 'car_brand' => $aCarBrand, 'gps' => $aGPSAdd];
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
            $aFormat = [
                'car_no'       => Config::get('validator.car_no'),
                'gps_id'       => Config::get('validator.id'),
                'car_type_id'  => Config::get('validator.id'),
                'car_brand_id' => Config::get('validator.id')
            ];
            $aGPS = $this->oGPSModel->find($aParam['gps_id'])->toArray();
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0 || !isset($aGPS['_id'])) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            $aParam['id'] = '';
            if ($this->oModel->checkSame($aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }
            /* 寫入資料 */
            $oResult = $this->oModel->create(array_merge([
                'car_no'       => $aParam['car_no'],
                'gps_id'       => $aParam['gps_id'],
                'gps_no'       => $aGPS['gps_no'],
                'city'         => $aGPS['city'],
                'car_type_id'  => $aParam['car_type_id'],
                'car_brand_id' => $aParam['car_brand_id']
            ], Website::getSaveInfo()));
            /* 更新GPS資料對應的車輛資料 */
            $this->oGPSModel->updateCar($aGPS['_id'], $oResult->_id);
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
            $aFormat = [
                'id'           => Config::get('validator.id'),
                'car_no'       =>  Config::get('validator.car_no'),
                'gps_id'       =>  Config::get('validator.id'),
                'car_type_id'  =>  Config::get('validator.id'),
                'car_brand_id' =>  Config::get('validator.id')
            ];
            $oOldInfo = $this->oModel->find($aParam['id']);
            $aGPS = $this->oGPSModel->find($aParam['gps_id'])->toArray();
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0 || !isset($oOldInfo->_id) || !isset($aGPS['_id'])) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            if ($this->oModel->checkSame($aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }
            /* 寫入資料 */
            $this->oModel->updateData($aParam['id'], array_merge([
                'car_no'       => $aParam['car_no'],
                'gps_id'       => $aParam['gps_id'],
                'gps_no'       => $aGPS['gps_no'],
                'city'         => $aGPS['city'],
                'car_type_id'  => $aParam['car_type_id'],
                'car_brand_id' => $aParam['car_brand_id']
            ], Website::getSaveInfo('edit')));
            /* 更新GPS資料對應的車輛資料 */
            if ($aParam['gps_id'] != $oOldInfo->gps_id) {
                $this->oGPSModel->updateCar($oOldInfo->gps_id, '');
                $this->oGPSModel->updateCar($aParam['gps_id'], $aParam['id']);
            }
            /* 回傳 */
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
     * 刪除資料
     * @param  string  $id
     * @param  array   aParam
     * @return array
     */
    public function delete($id, array $aParam = array())
    {
        try {
            /* 驗證資料 */
            $oOldInfo = $this->oModel->find($id);
            if (count(Validator::make(['id' => $id], ['id' => Config::get('validator.id')])->errors()->all()) > 0 || !isset($oOldInfo->_id)) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 刪除資料 */
            $this->oModel->destroy($id);
            $this->oGPSModel->updateCar($oOldInfo->gps_id, '');
            /* 回傳 */
            return [
                'result'   => true,
                'message'  => Lang::get('back.s_delete_data'),
                'redirect' => Website::getRedirect($aParam, $aParam['default_url'])
            ];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 刪除多筆資料
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function deleteMulti(array $aParam = array())
    {
        try {
            $aGPS = [];
            /* 驗證資料 */
            foreach($aParam['del'] as $id)
            {
                $oOldInfo = $this->oModel->find($id);
                if (count(Validator::make(['id' => $id], ['id' => Config::get('validator.id')])->errors()->all()) > 0 || !isset($oOldInfo->_id)) {
                    throw new \Exception(Lang::get('back.f_data_format'));
                }
                if($oOldInfo->gps_id != '') {
                    $aGPS[] = $oOldInfo->gps_id;
                }
            }
            /* 刪除資料 */
            $this->oModel->deleteMultiData($aParam['del']);
            $this->oGPSModel->clearCar($aGPS);
            /* 回傳 */
            return [
                'result'   => true,
                'message'  => Lang::get('back.s_delete_data'),
                'redirect' => Website::getRedirect($aParam, $aParam['default_url'])
            ];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }

}
