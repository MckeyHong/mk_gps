<?php
/* 邏輯 - GPS設定 */
namespace App\Services\Gps;

use App\Repository\Gps as Repository;
use Validator;
use Website;
use Config;
use Lang;
use Auth;

class SetService
{
    protected $oModel;

    public function __construct(Repository $Model)
    {
        $this->oModel = $Model;
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
                'no' => Config::get('validator.gps_no'),
                'c'  => Config::get('validator.city').implode('","', $aCity).'"'
            ],
            'replace' => ['no' => 'gps_no', 'c' => 'city'],
            'city'    => $aCity
        ]);
        $aInfo = $this->oModel->getList($aHandle['where']);
        return ['info' => $aInfo, 'get' => $aHandle['get'], 'city' => $aCity];
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
                'city'               => Config::get('validator.city').implode('","', Auth::user()->city).'"',
                'gps_no'             => Config::get('validator.gps_no'),
                'cellphone'          => 'required|max:20',
                'cellphone_provider' => 'required|max:20'
            ];
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            $aParam['id'] = '';
            if ($this->oModel->checkSame('gps', $aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same_gps'));
            }
            if ($this->oModel->checkSame('phone', $aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same_tel'));
            }
            /* 寫入資料 */
            $this->oModel->create(array_merge([
                'gps_no'             => $aParam['gps_no'],
                'cellphone'          => $aParam['cellphone'],
                'cellphone_provider' => $aParam['cellphone_provider'],
                'city'               => $aParam['city'],
                'car_id'             => ''
            ], Website::getSaveInfo()));
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
                'id'                 => Config::get('validator.id'),
                'city'               => Config::get('validator.city').implode('","', Auth::user()->city).'"',
                'gps_no'             => Config::get('validator.gps_no'),
                'cellphone'          => 'required|max:20',
                'cellphone_provider' => 'required|max:20'
            ];
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            if ($this->oModel->checkSame('gps', $aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same_gps'));
            }
            if ($this->oModel->checkSame('phone', $aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same_tel'));
            }
            /* 寫入資料 */
            $this->oModel->updateData($aParam['id'], array_merge([
                'gps_no'             => $aParam['gps_no'],
                'cellphone'          => $aParam['cellphone'],
                'cellphone_provider' => $aParam['cellphone_provider'],
                'city'               => $aParam['city']
            ], Website::getSaveInfo('edit')));
            /* 回傳 */
            return ['result'  => true, 'message' => Lang::get('back.s_edit_data')];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 刪除資料
     * @param  string $id
     * @return array
     */
    public function delete($id)
    {
        try {
            $aInfo = $this->oModel->find($id)->toArray();
            /* 驗證資料 */
            if (!isset($aInfo['_id']) || $aInfo['_id'] == '') {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 若有車輛配置則無法刪除 */
            if (isset($aInfo['car_id']) && $aInfo['car_id'] != '') {
                throw new \Exception(Lang::get('back.f_del_gps'));
            }
            /* 刪除資料 */
            $this->oModel->destroy($id);
            /* 回傳 */
            return ['result' => true, 'message' => Lang::get('back.s_delete_data')];
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
            /* 驗證資料 */
            foreach ($aParam['del'] as $id) {
                $aInfo = $this->oModel->find($id)->toArray();
                /* 驗證資料 */
                if (!isset($aInfo['_id']) || $aInfo['_id'] == '') {
                    throw new \Exception(Lang::get('back.f_data_format'));
                }
                /* 若有車輛配置則無法刪除 */
                if (isset($aInfo['car_id']) && $aInfo['car_id'] != '') {
                    throw new \Exception(Lang::get('back.f_del_gps'));
                }
            }
            /* 刪除資料 */
            $this->oModel->deleteMultiData($aParam['del']);
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
