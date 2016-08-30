<?php
/* 車輛品牌資料 */
namespace App\Repository;

use App\Entity\CarBrand as Entity;

class CarBrand extends Entity
{
    /**
     * 取得資料 (分頁使用)
     * @param  array  $aParam
     * @return object
     */
    public function getList(array $aParam = array())
    {

        $oQuery = $this;
        if (isset($aParam['brand_name']) && $aParam['brand_name'] != '') {
            $oQuery = $oQuery->where('brand_name', '=', $aParam['brand_name']);
        }
        return $oQuery->orderBy('brand_name', 'ASC')->Paginate($aParam['per_page']);
    }

    /**
     * 取得車輛品牌資料
     * @return object
     */
    public function getBrand($bGetID = true)
    {
        if ($bGetID === true) {
            return $this->orderBy('brand_name', 'ASC')->lists('brand_name', '_id');
        } else {
            return $this->orderBy('brand_name', 'ASC')->lists('brand_name');
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
                    ->where('brand_name', '=', $aParam['brand_name'])
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
