<?php
/*  商業邏輯 - 角色資料 */
namespace App\Services\Admin;

use App\Repository\UsersRole as Repository;
use Validator;
use Config;
use Lang;
use Website;

class PrivilegeService
{
    protected $oModel;

    public function __construct(Repository $Model)
    {
        $this->oModel = $Model;
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
        /* 取資料 */
        $aHandle = Website::handleGet([
            'get'     => $aParam,
            'format'  => ['role' => Config::get('validator.role')],
            'replace' => ['role' => 'role_name']
        ]);
        $aInfo = $this->oModel->getList($aHandle['where']);
        /* 回傳 */
        return ['info' => $aInfo, 'get' => $aHandle['get']];
    }

    /**
     * 取得初始資料（新增）
     * @return array
     */
    public function getInitial()
    {
        return [
            'role_name'      => '',
            'role_privilege' => array()
        ];
    }

    /**
     * 取得單筆資料
     * @param  string $sID
     * @return array
     */
    public function find($sID = '')
    {
        try {
            /* 驗證資料 */
            if (count(Validator::make(['id' => $sID], ['id' => Config::get('validator.id')])->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 刪除資料 */
            $aInfo = $this->oModel->find($sID)->toArray();
            if(!isset($aInfo['_id'])) {
                throw new \Exception(Lang::get('back.f_find_data'));
            }
            /* 回傳 */
            return ['result' => true, 'info' => $aInfo];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 新增資料
     * @param  array  $aParam
     * @return array
     */
    public function add(array $aParam = array())
    {
        try {
            $aParam['id'] = '';
            /* 驗證資料 */
            if (count(Validator::make($aParam, ['role_name' => Config::get('validator.role'), 'role_privilege' => 'array'])->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            if ($this->oModel->checkSame($aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }
            /* 寫入資料 */
            $this->oModel->create(array_merge([
                'role_name'      => $aParam['role_name'],
                'role_privilege' => (isset($aParam['role_privilege'])) ? (array)$aParam['role_privilege'] : array()
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
     * 更新資料
     * @param  string $sID
     * @param  array  $aParam
     * @return array
     */
    public function update($sID = '', array $aParam = array())
    {
        try {
            $aParam['id'] = $sID;
            /* 驗證資料 */
            $aFormat = [
                'id'             => Config::get('validator.id'),
                'role_name'      => Config::get('validator.role'),
                'role_privilege' => 'array'
            ];
            $oOldInfo = $this->oModel->find($aParam['id']);
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0 || !isset($oOldInfo->_id)) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            if ($this->oModel->checkSame($aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }
            /* 寫入資料 */
            $this->oModel->updateData($aParam['id'], array_merge([
                'role_name'      => $aParam['role_name'],
                'role_privilege' => isset($aParam['role_privilege']) ? (array)$aParam['role_privilege'] : array()
            ], Website::getSaveInfo('edit')));
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
            /* 檢查是否有管理員套用中 */
            if( $this->oModel->find($id)->checkUser() > 0) {
                throw new \Exception(Lang::get('back.f_role_user'));
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
                /* 檢查是否有管理員套用中 */
                if( $this->oModel->find($id)->checkUser() > 0) {
                    throw new \Exception(Lang::get('back.f_role_user'));
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
     * 檢查權限
     * @param  string $sRoleID
     * @param  string $sMenu
     * @return  boolean
     */
    public function checkPrivilege($sRoleID, $sMenu)
    {
        $bResult = false;
        /* 驗證參數是否正確 */
        $aCheck = Validator::make(
            ['id' => $sRoleID, 'menu' => $sMenu],
            ['id' => Config::get('validator.id'), 'menu' => 'required']
        );

        if (count($aCheck->errors()->all()) == 0) {
            $aInfo = $this->oModel->find($sRoleID);
            if (isset($aInfo['role_privilege']) && in_array($sMenu, $aInfo['role_privilege'])) {
                Auth::user()->setAttribute('RolePrivilege', $aInfo['role_privilege']);
                $bResult = true;
            }
        }
        return $bResult;
    }
}
