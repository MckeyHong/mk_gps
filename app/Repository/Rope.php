<?php
/* 鎖頭資訊 */
namespace App\Repository;

use App\Entity\Rope as Entity;

class Rope extends Entity
{
    /**
     * 取得資料 (分頁使用)
     * @param  array  $aParam
     * @return object
     */
    public function getList(array $aParam = array())
    {
        $oQuery = $this->whereIn('city', $aParam['city']);
        if (isset($aParam['rope_no']) && $aParam['rope_no'] != '') {
            $oQuery = $oQuery->where('rope_no', '=', $aParam['rope_no']);
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
                    ->where('rope_no', '=', $aParam['rope_no'])
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
     * 歸還多筆資料
     * @param  array   $aParam
     * @return boolean
     */
    public function returnMultiData(array $aParam = array())
    {
        return $this->whereIn('_id', $aParam)->update(array('rope_status' => 1, 'staff_info' => array()), array('upsert' => true));
    }

}
