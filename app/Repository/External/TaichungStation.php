<?php
/**
 * 工作狀態資料
 */
namespace App\Repository\External;

use App\Entity\External\TaichungStation as Entity;

class TaichungStation extends Entity
{
    /**
     * 取得資料
     * @param  array  $aParam
     * @return object
     */
    public function getAll(array $aParam = array())
    {

        return $this->get();
    }

}
