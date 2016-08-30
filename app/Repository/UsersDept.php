<?php
/**
 * 組織部門資料
 */
namespace App\Repository;

use App\Entity\UsersDept as Entity;

class UsersDept extends Entity
{
    /**
     * 取得所有資料
     * @param  array  $aParam
     * @return object
     */
    public function getAll(array $aParam = array())
    {
        return $this->whereIn('city', $aParam['city'])->orderBy('level', 'ASC')->orderBy('sort', 'ASC')->get();
    }

    /**
     * 檢查是否有相同資料
     * @param  array   $aParam
     * @return integer
     */
    public function checkSame(array $aParam = array())
    {
        return $this->where('_id', '!=', $aParam['id'])
                    ->where('parent_id', '=', $aParam['parent_id'])
                    ->where('dept_name', '=', $aParam['dept_name'])
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

}
