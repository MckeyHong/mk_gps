<?php
/* 工作狀態資料 */
namespace App\Repository;

use App\Entity\MaintainUnit as Entity;

class MaintainUnit extends Entity
{
    /**
     * 取得所有資料
     * @param  array  $aParam
     * @return object
     */
    public function getAll(array $aParam = array())
    {

        $oQuery = $this;
        if (isset($aParam['unit_name']) && $aParam['unit_name'] != '') {
            $oQuery = $oQuery->where('unit_name', '=', $aParam['unit_name']);
        }
        return $oQuery->get();
    }

}
