<?php
/* 邏輯 - 車輛檢查設定 */
namespace App\Services\Car;

use App\Repository\CarBrand as Repository;
use Validator;
use Website;
use Config;
use Lang;

class CheckSetService
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
        $aBrand = $this->oModel->getBrand(false)->toArray();
        /* 取資料 */
        $aHandle = Website::handleGet([
            'get'     => $aParam,
            'format'  => ['brand' => Config::get('validator.car_band').'|in:"'.implode('","', $aBrand)],
            'replace' => ['brand' => 'brand_name']
        ]);
        $aInfo = $this->oModel->getList($aHandle['where']);
        return ['info' => $aInfo, 'get' => $aHandle['get'], 'brand' => $aBrand];
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
                'brand_name' => Config::get('validator.car_band'),
                'item'       => 'required|array'
            ];
            $aItem = $this->handle_item($aParam['item']);
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0 || count($aItem) == 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            $aParam['id'] = '';
            if ($this->oModel->checkSame($aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }
            /* 寫入資料 */
            $this->oModel->create(array_merge([
                'brand_name' => $aParam['brand_name'],
                'check_item' => $aItem
            ], Website::getSaveInfo()));
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
                'id'         => Config::get('validator.id'),
                'brand_name' => Config::get('validator.car_band'),
                'item'       => 'required|array'
            ];
            $aItem = $this->handle_item($aParam['item']);
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0 || count($aItem) == 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            if ($this->oModel->checkSame($aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }
            /* 寫入資料 */
            $this->oModel->updateData($aParam['id'], array_merge([
                'brand_name' => $aParam['brand_name'],
                'check_item' => $aItem
            ], Website::getSaveInfo('edit')));
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
     * 處理要儲存的檢查項目
     * @param  array  $aParam
     * @return array
     */
    private function handle_item(array $aParam = array())
    {
        $aItem = [];
        foreach ($aParam as $sItem) {
            if ($sItem != '') {
                $aItem[$sItem] = $sItem;
            }
        }
        return array_keys($aItem);
    }
}
