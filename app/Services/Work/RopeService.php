<?php
/* 邏輯 - 鎖頭資訊 */
namespace App\Services\Work;

use App\Repository\Rope as Repository;
use Validator;
use Website;
use Config;
use Lang;
use Auth;

class RopeService
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
                'rope' => Config::get('validator.rope'),
                'c'    => Config::get('validator.city').implode('","', $aCity).'"'],
            'replace' => ['rope' => 'rope_no', 'c' => 'city'],
            'city'    => $aCity
        ]);
        $aInfo = $this->oModel->getList($aHandle['where']);
        /* 整理列表顯示資料 */
        foreach ($aInfo as $iKey => $aVal) {
            $aInfo[$iKey]['city_name'] = Lang::get('website.city_'.$aVal['city']);
            if ($aVal['rope_status'] == 1) {
                $aInfo[$iKey]['status_name'] = Lang::get('website.rope_not_use');
                $aInfo[$iKey]['staff_info'] = '';
            } else {
                $aInfo[$iKey]['status_name'] = Lang::get('website.rope_use');
                $aInfo[$iKey]['staff_info'] = implode(',', array_pluck($aVal['staff_info'], 'username'));
            }
        }
        /* 回傳 */
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
                'rope_no' => Config::get('validator.rope'),
                'city'    => Config::get('validator.city').implode('","', Auth::user()->city).'"'
            ];
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            $aParam['id'] = '';
            if ($this->oModel->checkSame($aParam) > 0) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }
            /* 寫入資料 */
            $this->oModel->create(array_merge([
                'city'        => $aParam['city'],
                'rope_no'     => $aParam['rope_no'],
                'rope_status' => 1,
                'staff_info'  => array()
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
                'id'      => Config::get('validator.id'),
                'rope_no' => Config::get('validator.rope'),
                'city'    => Config::get('validator.city').implode('","', Auth::user()->city).'"'
            ];
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            if ($this->oModel->checkSame($aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }
            /* 寫入資料 */
            $this->oModel->updateData($aParam['id'], array_merge([
                'city'    => $aParam['city'],
                'rope_no' => $aParam['rope_no']
            ], Website::getSaveInfo('edit')));
            /* 回傳 */
            return ['result' => true, 'message' => Lang::get('back.s_edit_data')];
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
            /* 驗證資料 */
            if (count(Validator::make(['id' => $id], ['id' => Config::get('validator.id')])->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
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
                if (count(Validator::make(['id' => $id], ['id' => Config::get('validator.id')])->errors()->all()) > 0) {
                    throw new \Exception(Lang::get('back.f_data_format'));
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

    /**
     * 歸還多筆資料
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function returnMulti(array $aParam = array())
    {
        try {
            /* 驗證資料 */
            foreach ($aParam['id'] as $id) {
                if (count(Validator::make(['id' => $id], ['id' => Config::get('validator.id')])->errors()->all()) > 0) {
                    throw new \Exception(Lang::get('back.f_data_format'));
                }
            }
            /* 設定歸還資料 */
            $this->oModel->returnMultiData($aParam['id']);
            /* 回傳 */
            return [
                'result'   => true,
                'message'  => Lang::get('back.s_rope_return'),
                'redirect' => Website::getRedirect($aParam, $aParam['default_url'])
            ];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }

}