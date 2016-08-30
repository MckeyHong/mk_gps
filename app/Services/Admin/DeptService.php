<?php
/**
 * 商業邏輯 - 部門組織資料
 */
namespace App\Services\Admin;

use App\Repository\UsersDept as Repository;
use Validator;
use Website;
use Config;
use Lang;
use Auth;
use Request;

class DeptService
{

    protected $oModel;
    private $sRedirect;

    public function __construct(Repository $Model)
    {
        $this->oModel = $Model;
        $this->sRedirect = Request::root().'/Admin/Dept';
    }

    /**
     * 列表頁面
     * @return array
     */
    public function getList()
    {
        /* 處理顯示資訊 */
        $handInfo = function ($aParam) {
            return [
                '_id'        => $aParam['_id'],
                'city'       => $aParam['city'],
                'level'      => $aParam['level'],
                'dept_name'  => $aParam['dept_name'],
                'staff_info' => $aParam['staff_info'],
                'child'      => array()
            ];
        };
        $aTemp = $this->oModel->getAll(array('city' => Auth::user()->city));
        $aInfo = array();
        foreach ($aTemp as $aVal) {
            switch($aVal['level']) {
                case 1:
                    $aInfo[$aVal['_id']] = $handInfo($aVal);
                break;
                case 2:
                    $aInfo[$aVal['parent_arr'][0]]['child'][$aVal['_id']] = $handInfo($aVal);
                break;
                case 3:
                    $aInfo[$aVal['parent_arr'][0]]['child'][$aVal['parent_arr'][1]]['child'][$aVal['_id']] = $handInfo($aVal);
                break;
                case 4:
                    $aInfo[$aVal['parent_arr'][0]]['child'][$aVal['parent_arr'][1]]['child'][$aVal['parent_arr'][2]]['child'][$aVal['_id']] = $handInfo($aVal);
                break;
                default:
                break;
            }
        }
        return ['info' => $aInfo];
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
                'dept_name'  => 'required|max:30',
                'parent_id'  => 'required|alpha_num|min:24|max:24',
                'city'       => 'required|in:"'.implode('","', Auth::user()->city).'"',
                'level'      => 'required|in:"2","3","4"',
                'parent_arr' => 'required'
            ];
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            $aParam['id'] = '';
            if ($this->oModel->checkSame($aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }

            /* 寫入資料 */
            $sTime = time();
            $aSaveParam = array(
                'city'        => $aParam['city'],
                'dept_name'   => $aParam['dept_name'],
                'parent_id'   => $aParam['parent_id'],
                'parent_arr'  => explode(',', $aParam['parent_arr']),
                'level'       => (int)$aParam['level'],
                'sort'        => 99,
                'staff_info'  => array(),
                'create_date' => $sTime,
                'create_user' => Auth::user()->_id,
                'modify_date' => $sTime,
                'modify_user' => Auth::user()->_id
            );
            $this->oModel->create($aSaveParam);

            return array('result' => true, 'message' => Lang::get('back.s_add_data'), 'redirect' => Website::getRedirect($aParam, $this->sRedirect));
        } catch (\Exception $e) {
            return array('result' => false, 'message' => $e->getMessage());
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
            $aFormat = array(
                'id'        => 'required|alpha_num|min:24|max:24',
                'parent_id' => 'required|alpha_num|min:24|max:24',
                'dept_name' => 'required|max:30'
            );
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            if ($this->oModel->checkSame($aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }
            /* 寫入資料 */
            $aSaveParam = array(
                'dept_name'   => $aParam['dept_name'],
                'modify_date' => time(),
                'modify_user' => Auth::user()->_id
            );
            $this->oModel->updateData($aParam['id'], $aSaveParam);

            return array('result' => true, 'message' => Lang::get('back.s_edit_data'), 'redirect' => Website::getRedirect($aParam, $this->sRedirect));
        } catch (\Exception $e) {
            return array('result' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * 刪除資料
     * @param  string $id
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function delete($id, array $aParam = array())
    {
        try {
            /* 驗證資料 */
            if (count(Validator::make(array('id' => $id), array('id' => 'required|alpha_num|min:24|max:24'))->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 刪除資料 */
            $this->oModel->destroy($id);

            return array('result' => true, 'message' => Lang::get('back.s_delete_data'), 'redirect' => Website::getRedirect($aParam, $this->sRedirect));
        } catch (\Exception $e) {
            return array('result' => false, 'message' => $e->getMessage());
        }
    }

}
