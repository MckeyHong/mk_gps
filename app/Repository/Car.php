<?php
/* 車輛資料 */
namespace App\Repository;

use App\Entity\Car as Entity;

class Car extends Entity
{
    /**
     * 取得資料 (分頁使用)
     * @param  array  $aParam
     * @return object
     */
    public function getList(array $aParam = array())
    {
        $oQuery = $this->whereIn('city', $aParam['city']);
        foreach (array('car_no', 'car_type_id', 'gps_no') as $sVal) {
            if (isset($aParam[$sVal]) && $aParam[$sVal] != '') {
                $oQuery = $oQuery->where($sVal, '=', $aParam[$sVal]);
            }
        }

        return $oQuery->orderBy('car_no', 'ASC')->Paginate($aParam['per_page']);
    }

    /**
     * 檢查是否有相同資料
     * @param  array   $aParam
     * @return integer
     */
    public function checkSame(array $aParam = array())
    {
        return $this->where('_id', '!=', $aParam['id'])
                    ->where('car_no', '=', $aParam['car_no'])
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
