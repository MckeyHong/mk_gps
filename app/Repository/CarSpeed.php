<?php
/* 車輛速度設定 */
namespace App\Repository;

use App\Entity\CarSpeed as Entity;

class CarSpeed extends Entity
{
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
