<?php
/* GPS設備資料 */
namespace App\Repository;

use App\Entity\Gps as Entity;

class Gps extends Entity
{
    /**
     * 取得資料 (分頁使用)
     * @param  array  $aParam
     * @return object
     */
    public function getList(array $aParam = array())
    {
        $oQuery = $this->whereIn('city', $aParam['city']);
        if (isset($aParam['gps_no']) && $aParam['gps_no'] != '') {
            $oQuery = $oQuery->where('gps_no', '=', $aParam['gps_no']);
        }
        return $oQuery->orderBy('city', 'ASC')
                      ->orderBy('gps_no', 'ASC')
                      ->Paginate($aParam['per_page']);
    }

    /**
     * 取得GPS資料
     * @return object
     */
    public function getGPS()
    {
        return $this->orderBy('city', 'ASC')
                    ->orderBy('gps_no', 'ASC')
                    ->get(['_id', 'gps_no', 'cellphone', 'cellphone_provider', 'city', 'car_id']);
    }

    /**
     * 檢查是否有相同資料
     * @param  string   $sType
     * @param  array    $aParam
     * @return integer
     */
    public function checkSame($sType = 'gps', array $aParam = array())
    {
        if ($sType == 'phone') {
            return $this->where('_id', '!=', $aParam['id'])
                        ->where('cellphone', '=', $aParam['cellphone'])
                        ->count();
        } else {
            return $this->where('_id', '!=', $aParam['id'])
                        ->where('gps_no', '=', $aParam['gps_no'])
                        ->count();
        }
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
     * 更新GPS對應的車輛資料
     * @param  string $sID
     * @param  array  $sCarID
     * @return boolean
     */
    public function updateCar($sID = '', $sCarID = '')
    {
        return $this->where('_id', $sID)->update(array('car_id' => $sCarID), array('upsert' => true));
    }

    /**
     * 更新GPS對應的車輛資料
     * @param  array $aID
     * @return boolean
     */
    public function clearCar(array $aID = array())
    {
        return $this->whereIn('_id', $aID)->update(array('car_id' => ''), array('upsert' => true));
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
