<?php
/* 車輛種類資料 */
namespace App\Repository;

use App\Entity\CarType as Entity;

class CarType extends Entity
{
    /**
     * 取得資料 (分頁使用)
     * @param  array  $aParam
     * @return object
     */
    public function getList(array $aParam = array())
    {

        $oQuery = $this;
        if (isset($aParam['car_type']) && $aParam['car_type'] != '') {
            $oQuery = $oQuery->where('car_type', '=', $aParam['car_type']);
        }
        return $oQuery->orderBy('car_type', 'ASC')->Paginate($aParam['per_page']);
    }

    /**
     * 取得車輛種類資料
     * @return object
     */
    public function getType($bGetID = true)
    {
        if ($bGetID === true) {
            return $this->orderBy('car_type', 'ASC')->lists('car_type', '_id');
        } else {
            return $this->orderBy('car_type', 'ASC')->lists('car_type');
        }
    }

    /**
     * 檢查是否有相同資料
     * @param  array   $aParam
     * @return integer
     */
    public function checkSame(array $aParam = array())
    {
        return $this->where('_id', '!=', $aParam['id'])
                    ->where('car_type', '=', $aParam['car_type'])
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
