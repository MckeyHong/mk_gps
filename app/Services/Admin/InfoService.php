<?php
/**
 * 商業邏輯 - 管理員資料
 */
namespace App\Services\Admin;

use App\Repository\User as Repository;
use App\Repository\UsersRole as RoleRepository;
use App\Repository\UsersDept as DeptRepository;
use Validator;
use Config;
use Auth;
use Lang;

class InfoService
{
    protected $oModel;
    protected $oRoleModel;
    protected $oDeptModel;

    public function __construct(Repository $Model, RoleRepository $RoleModel, DeptRepository $oDeptModel)
    {
        $this->oModel = $Model;
        $this->oRoleModel = $RoleModel;
        $this->oDeptModel = $oDeptModel;
    }

    /**
     * 列表頁面
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getList(array $aParam = array())
    {
        /* Set */
        $aDept = array();
        $aGet = $aSearch = array();
        $aReplace = array('acc' => 'username', 'dept' => 'dept_id');
        /* 驗證查詢參數是否正確 */
        $aFormat = array(
            'acc'  => 'required|alpha_num|min:4|max:15',
            'dept' => 'required|in:"'.implode('","', $aDept).'"'
        );
        $aError = Validator::make($aParam, $aFormat)->messages();
        foreach ($aFormat as $sKey => $sVal) {
            $aGet[$sKey] = ($aError->has($sKey)) ?  '' : $aParam[$sKey];
            $aSearch[$aReplace[$sKey]] = $aGet[$sKey];
        }
        $aSearch['per_page'] = Config::get('website.per_page');
        $aInfo = $this->oModel->getList($aSearch);
        foreach ($aInfo as $iKey => $aVal) {
            $aInfo[$iKey]['dept_info'] = '台北市 > 大安區 > 維修組 > 維修工程師';
        }
        return array('info' => $aInfo, 'get' => $aGet);
    }

    /**
     * 取得初始資料（新增）
     * @return array
     */
    public function getInitial()
    {
        return array(
            'role' => $this->oRoleModel->getAll(),
            'dept' => $this->getDept(),
            'info' => array(
                '_method'     => 'post',
                'username'    => '',
                'users_name'  => '',
                'role_id'     => '',
                'dept_id'     => '',
                'area'        => '',
                'enable_type' => 1,
                'city'        => array()
            )
        );
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
            if (count(Validator::make(array('id' => $sID), array('id' => 'required|alpha_num|min:24|max:24'))->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 刪除資料 */
            $aInfo = $this->oModel->find($sID)->toArray();
            if(!isset($aInfo['_id'])) {
                throw new \Exception(Lang::get('back.f_find_data'));
            }
            $aInfo['_method'] = 'put';
            return array('result' => true, 'info' => $aInfo, 'role' => $this->oRoleModel->getAll(), 'dept' => $this->getDept());
        } catch (\Exception $e) {
            return array('result' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * 更新個人密碼
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function changePwd(array $aParam = array())
    {
        try {
            /* 驗證資料 */
            $aFormat = array(
                'self_pwd_old' => 'required|alpha_num|min:6|max:15',
                'self_pwd'     => 'required|alpha_num|min:6|max:15',
                'self_pwd_chk' => 'required|alpha_num|min:6|max:15'
            );
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0 || $aParam['self_pwd'] != $aParam['self_pwd_chk']) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 目前密碼輸入錯誤 */
            if (!Auth::attempt(array('username' => Auth::user()->username, 'password' => $aParam['self_pwd_old']))) {
                throw new \Exception(Lang::get('back.f_now_pwd'));
            }
            /* 執行更改密碼動作 */
            $this->oModel->updateData(Auth::user()->_id, array('password' => bcrypt($aParam['self_pwd'])));
            return array('result' => true, 'message' => Lang::get('back.s_change_pwd'));
        } catch (\Exception $e) {
            return array('result' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * 取得部門組織資訊
     * @return array
     */
    private function getDept()
    {
        $aTemp = $this->oDeptModel->getAll(array('city' => Auth::user()->city))->toArray();
        $aInfo = array();
        foreach($aTemp as $aVal) {
            $aInfo[$aVal['level']][] = $aVal;
        }
        return $aInfo;
    }

}
