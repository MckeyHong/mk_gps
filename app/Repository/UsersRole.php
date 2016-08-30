<?php
/**
 * 角色資料
 */
namespace App\Repository;

use App\Entity\UsersRole as Entity;

class UsersRole extends Entity
{
    private $orderBy = 'modify_date';

    /**
     * 取得資料（管理者列表）
     * @param  array  $aParam
     * @return object
     */
    public function getList(array $aParam = array())
    {
        $query = $this;
        $aWhere = array('role_name');
        foreach ($aWhere as $sVal) {
            if (isset($aParam[$sVal]) && $aParam[$sVal] != '') {
                $query = $query->where($sVal, '=', $aParam[$sVal]);
            }
        }
        return $query->orderBy($this->orderBy)->Paginate($aParam['per_page']);
    }

    /**
     * 取得所有資料
     * @return object
     */
    public function getAll()
    {
        return $this->orderBy($this->orderBy)->lists('role_name', '_id');
    }

    /**
     * 檢查是否有相同資料
     * @param  array   $aParam
     * @return integer
     */
    public function checkSame(array $aParam = array())
    {
        return $this->where('_id', '!=', $aParam['id'])
                    ->where('role_name', '=', $aParam['role_name'])
                    ->count();
    }

    /**
     * 更新資料
     * @param  string $sID
     * @param  array  $aParam
     * @return boolean
     */
    public function updateData($sID = '', array $aParam = array())
    {
        return $this->where('_id', $sID)->update($aParam, array('upsert' => true));
    }

    /**
     * 刪除多筆資料
     * @param  array   $aParam
     * @return boolean
     */
    public function deleteMultiData(array $aParam = array())
    {
        return $this->whereIn('_id', $aParam)->delete();
    }

    /**
     * 檢查是否有管理員套用中
     * @return integer
     */
    public function checkUser()
    {
        return $this->hasMany('App\Repository\User', 'role_id', '_id')->count();
    }
}
