<?php
/* 邏輯 - 工作班別設定 > 班表設定 */
namespace App\Services\Work;

use App\Repository\ShiftsInfo as Repository;
use Validator;
use Website;
use Config;
use Lang;

class ShiftSetService
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
            'format'  => ['shift' => 'required|max:10'],
            'replace' => ['shift' => 'shift_name']
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
            $aFormat = [
                'shift_name'       => 'required|max:10',
                'shift_start_time' => 'required|max:10',
                'shift_end_time'   => 'required|max:10'
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
                'shift_name'       => $aParam['shift_name'],
                'shift_start_time' => $aParam['shift_start_time'],
                'shift_end_time'   => $aParam['shift_end_time']
            ], Website::getSaveInfo()));
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
                'id'               => Config::get('validator.id'),
                'shift_name'       => 'required|max:10',
                'shift_start_time' => 'required|max:10',
                'shift_end_time'   => 'required|max:10'
            ];
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            if ($this->oModel->checkSame($aParam) > 0) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }
            /* 寫入資料 */
            $this->oModel->updateData($aParam['id'], array_merge([
                'shift_name'       => $aParam['shift_name'],
                'shift_start_time' => $aParam['shift_start_time'],
                'shift_end_time'   => $aParam['shift_end_time']
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
