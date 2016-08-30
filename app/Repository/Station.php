<?php
/**
 * 場站資料
 */
namespace App\Repository;

use App\Entity\Station as Entity;

class Station extends Entity
{
    /**
     * 取得資料 - 工作區域設定 (分頁使用)
     * @param  array  $aParam
     * @return object
     */
    public function getList(array $aParam = array())
    {
        $oQuery = $this->whereIn('city', $aParam['city']);
        if (isset($aParam['set_area']) && $aParam['set_area'] != '') {
            $oQuery = $oQuery->where('set_area', '=', $aParam['set_area']);
        }
        return $oQuery->orderBy('station_no', 'ASC')->Paginate($aParam['per_page']);
    }

    /**
     * 取得資料 - 場站調度設定 (分頁使用)
     * @param  array  $aParam
     * @return object
     */
    public function getDaySetList(array $aParam = array())
    {
        $oQuery = $this->whereIn('city', $aParam['city']);
        if (isset($aParam['station_no']) && $aParam['station_no'] != '') {
            $oQuery = $oQuery->where('station_no', '=', $aParam['station_no']);
        }
        return $oQuery->orderBy('station_no', 'ASC')->Paginate($aParam['per_page']);
    }

    /**
     * 取得資料
     * @param  array  $aParam
     * @return object
     */
    public function getAll(array $aParam = array())
    {
        $oQuery = $this->whereIn('city', $aParam['city']);
        if (isset($aParam['set_area']) && $aParam['set_area'] != '') {
            $oQuery = $oQuery->where('set_area', '=', $aParam['set_area']);
        }
        if (isset($aParam['station_status']) && $aParam['station_status'] != '') {
            $oQuery = $oQuery->where('station_status', '=', $aParam['station_status']);
        }
        return $oQuery->get();
    }

    /**
     * 取得資料 - 場站調度設定
     * @param  array  $aParam
     * @return object
     */
    public function getDaySetAll(array $aParam = array())
    {
        $oQuery = $this->whereIn('city', $aParam['city']);
        if (isset($aParam['station_no']) && $aParam['station_no'] != '') {
            $oQuery = $oQuery->where('station_no', '=', $aParam['station_no']);
        }
        return $oQuery->orderBy('station_no', 'ASC')->get();
    }

    /**
     * 更新資料(用於場站調度設定)
     * @param  string $sStationNo
     * @param  array  $aParam
     * @return boolean
     */
    public function updateDaySet($sStationNo = '', array $aParam = array())
    {
        return $this->where('station_no', $sStationNo)->update($aParam, array('upsert' => true));
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
}
