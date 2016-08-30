<?php
/* 人員班別資訊 */
namespace App\Repository;

use App\Entity\StaffShifts as Entity;

class StaffShifts extends Entity
{
    /**
     * 取得資料 (分頁使用)
     * @param  array  $aParam
     * @return object
     */
    public function getList(array $aParam = array())
    {

        $oQuery = $this->where('shift_date', '=', $aParam['shift_date']);
        if (isset($aParam['shift_name']) && $aParam['shift_name'] != '') {
            $oQuery = $oQuery->where('shift_name', '=', $aParam['shift_name']);
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
                    ->where('shift_name', '=', $aParam['shift_name'])
                    ->count();
    }
}
