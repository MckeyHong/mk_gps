<?php
/* 地方區域設定 */
namespace App\Repository;

use App\Entity\GpsArea as Entity;

class GpsArea extends Entity
{
    /**
     * 取得資料 (分頁使用)
     * @param  array  $aParam
     * @return object
     */
    public function getList(array $aParam = array())
    {
        return $this->whereIn('city', $aParam['city'])
                    ->orderBy('city', 'ASC')
                    ->orderBy('belong_station', 'ASC')
                    ->orderBy('belong_area', 'ASC')
                    ->Paginate($aParam['per_page']);
    }

    /**
     * 檢查是否有相同資料
     * @param  array   $aParam
     * @return integer
     */
    public function checkSame(array $aParam = array())
    {
        return $this->where('_id', '!=', $aParam['id'])
                    ->where('city', '=', $aParam['city'])
                    ->where('belong_station', '=', $aParam['belong_station'])
                    ->where('belong_area', '=', $aParam['belong_area'])
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
