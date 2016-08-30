<?php
namespace App\Repository;

use Jenssegers\Mongodb\Model as Model;
use App\Entity\User as Entity;

class User extends Model
{
    protected $oModel;
    protected $orderBy = 'username';

    public function __construct()
    {
        $this->oModel = new Entity;
    }

    /* 取列表資料 */
    public function getList(array $aParam = array())
    {
        $oQuery = $this->oModel;
        $aWhere = array('username', 'dept_id');
        foreach ($aWhere as $sVal) {
            if (isset($aParam[$sVal]) && $aParam[$sVal] != '') {
                $oQuery = $oQuery->where($sVal, '=', $aParam[$sVal]);
            }
        }
        return $oQuery->orderBy($this->orderBy)->Paginate($aParam['per_page']);
    }

    /**
     * 尋找該人員
     * @param  string $sUsername
     * @return object
     */
    public function findUsername($sUsername = '')
    {
        return $this->where('username', $sUsername)->get();
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
     * 更新匯入的資料
     * @param  string $aParam
     * @param  stinrg $sValue
     * @param  stinrg $sFiled
     * @return boolen
     */
    public function importUpdate(array $aParam = array(), $sValue = '', $sFiled = 'username')
    {
        return $this->where('username', $sValue)->update($aParam, array('upsert' => true));
    }

    /**
     * 清除多筆資料
     * @param  array   $aID
     * @param  array   $aParam
     * @return boolean
     */
    public function clearAllocationMulti(array $aID = array(), array $aParam = array())
    {
        return $this->whereIn('_id', $aID)->update($aParam, array('upsert' => true));
    }

}
