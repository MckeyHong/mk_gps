<?php
/**
 * 商業邏輯 - 車輛保修記錄
 */
namespace App\Services\Car;

use App\Repository\User as Repository;
use Validator;
use Config;

class MaintainService
{
    protected $oModel;

    public function __construct(Repository $Model)
    {
        $this->oModel = $Model;
    }

    /**
     * 列表頁面
     * @param  \Illuminate\Http\Request  $request
     * @return array         [array('info' => '')]
     */
    public function getList(array $aParam = array())
    {
        /* Set */
        $aInfo = $aGet = $aSearch = array();
        // $aReplace = array('role' => 'role_name');
        // /* 驗證查詢參數是否正確 */
        // $aFormat = array(
        //     'role'  => 'required|max:20'
        // );
        // $aError = Validator::make($aParam, $aFormat)->messages();
        // foreach ($aFormat as $sKey => $sVal) {
        //     $aGet[$sKey] = ($aError->has($sKey)) ?  '' : $aParam[$sKey];
        //     $aSearch[$aReplace[$sKey]] = $aGet[$sKey];
        // }
        // $aSearch['per_page'] = Config::get('website.per_page');
        // $aInfo = $this->oModel->getList($aSearch);
        return array('info' => $aInfo, 'get' => $aGet);
    }

}
