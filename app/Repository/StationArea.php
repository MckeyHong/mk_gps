<?php
/**
 * 場站工作區域資料
 */
namespace App\Repository;

use App\Entity\StationArea as Entity;

class StationArea extends Entity
{
    /**
     * 取得所有資料
     * @return object
     */
    public function getAll()
    {
        return $this->orderBy('area_name', 'ASC')->get();
    }

    /**
     * 取得所有資料(只取名稱)
     * @return object
     */
    public function getArea()
    {
        return $this->orderBy('area_name', 'ASC')->lists('area_name');
    }

    /**
     * 檢查是否有相同資料
     * @param  array   $aParam
     * @return integer
     */
    public function checkSame(array $aParam = array())
    {
        return $this->where('_id', '!=', $aParam['id'])
                    ->where('area_name', '=', $aParam['area_name'])
                    ->count();
    }

}
