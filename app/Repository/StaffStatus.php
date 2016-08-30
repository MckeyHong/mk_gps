<?php
/**
 * 人員狀態資料
 */
namespace App\Repository;

use App\Entity\StaffStatus as Entity;

class StaffStatus extends Entity
{
    /**
     * 取得資料 (分頁使用)
     * @param  array  $aParam
     * @return object
     */
    public function getList(array $aParam = array())
    {

        $oQuery = $this;
        if (isset($aParam['status_name']) && $aParam['status_name'] != '') {
            $oQuery = $oQuery->where('status_name', '=', $aParam['status_name']);
        }
        return $oQuery->Paginate($aParam['per_page']);
    }

    /**
     * 檢查是否有相同資料
     * @param  array   $aParam
     * @return integer
     */
    public function checkSame(array $aParam = array())
    {
        return $this->where('_id', '!=', $aParam['id'])
                    ->where('status_name', '=', $aParam['status_name'])
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
