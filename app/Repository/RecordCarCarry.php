<?php
/* 車輛相關記錄查詢 */
namespace App\Repository;

use App\Entity\RecordCarCarry as Entity;

class RecordCarCarry extends Entity
{
    /**
     * 取得資料 (分頁使用)
     * @param  array  $aParam
     * @return object
     */
    public function getList(array $aParam = array())
    {
        $oQuery = $this->whereBetween('create_date', array($aParam['start'], $aParam['end']));
        if (isset($aParam['car_no']) && $aParam['car_no'] != '') {
            $oQuery = $oQuery->where('car_no', '=', $aParam['car_no']);
        }
        if (isset($aParam['city_name']) && $aParam['city_name'] != '') {
            $oQuery = $oQuery->where('city_name', '=', $aParam['city_name']);
        }
        return $oQuery->orderBy('create_date', 'DESC')->Paginate($aParam['per_page']);
    }

}
