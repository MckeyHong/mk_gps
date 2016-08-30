<?php
/* 車輛檢查異常資料 */
namespace App\Repository;

use App\Entity\CarAbnormal as Entity;

class CarAbnormal extends Entity
{
    /**
     * 取得資料 (分頁使用)
     * @param  array  $aParam
     * @return object
     */
    public function getList(array $aParam = array())
    {

        $oQuery = $this;
        if (isset($aParam['car_no']) && $aParam['car_no'] != '') {
            $oQuery = $oQuery->where('car_no', '=', $aParam['car_no']);
        }
        if (isset($aParam['start']) && $aParam['start'] != '' && isset($aParam['end']) && $aParam['end'] != '') {
            $oQuery = $oQuery->whereBetween('create_date', array($aParam['start'], $aParam['end']));
        }
        return $oQuery->Paginate($aParam['per_page']);
    }

}
