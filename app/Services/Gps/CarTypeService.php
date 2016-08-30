<?php
/* 邏輯 - 車輛種類設定 */
namespace App\Services\Gps;

use App\Repository\CarType as Repository;
use Validator;
use Website;
use Config;
use Lang;

class CarTypeService
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
        /* 取資料 */
        $aHandle = Website::handleGet([
            'get'     => $aParam,
            'format'  => ['type' => Config::get('validator.car_type')],
            'replace' => ['type' => 'car_type']
        ]);
        $aInfo = $this->oModel->getList($aHandle['where']);
        return ['info' => $aInfo, 'get' => $aHandle['get']];
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
            if (count(Validator::make($aParam, ['car_type' => Config::get('validator.car_type')])->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            $aParam['id'] = '';
            if ($this->oModel->checkSame($aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }
            /* 寫入資料 */
            $this->oModel->create(array_merge(['car_type' => $aParam['car_type']], Website::getSaveInfo()));
            return [
                'result'   => true,
                'message'  => Lang::get('back.s_add_data'),
                'redirect' => Website::getRedirect($aParam, $aParam['default_url'])
            ];
        } catch (\Exception $e) {
            return [
                'result'  => false,
                'message' => $e->getMessage()
            ];
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
                'id'       => Config::get('validator.id'),
                'car_type' => Config::get('validator.car_type')
            ];
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            if ($this->oModel->checkSame($aParam) > 0) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }
            /* 寫入資料 */
            $this->oModel->updateData($aParam['id'], array_merge(['car_type' => $aParam['car_type']], Website::getSaveInfo('edit')));
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

}
