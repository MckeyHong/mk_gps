<?php
/**
 * 商業邏輯 - 地圖狀態顯示
 */
namespace App\Services\Map;

use App\Repository\Station as Repository;
use App\Repository\StationArea as AreaRepository;
use Validator;
use Config;
use Lang;
use Auth;

class InfoService
{
    protected $oModel;
    protected $AreaModel;

    public function __construct(Repository $Model, AreaRepository $AreaModel)
    {
        $this->oModel = $Model;
        $this->AreaModel = $AreaModel;
    }

    /**
     * 列表頁面
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getList(array $aParam = array())
    {
        /* Set */
        $aInfo = $aGet = $aSearch = array();
        $aReplace = array('status' => 'station_status', 'c' => 'city', 'area' => 'set_area');
        $aCity = Auth::user()->city;
        $aStatus = config('website.station_status');
        $aArea = $this->AreaModel->getArea()->toArray();

        /* 驗證查詢參數是否正確 */
        $aFormat = array(
            'status' => 'required|in:"'.implode('","', $aStatus).'"',
            'c'      => 'required|in:"'.implode('","', $aCity).'"',
            'area'   => 'required|in:"'.implode('","', $aArea).'"'
        );

        $aError = Validator::make($aParam, $aFormat)->messages();
        foreach ($aFormat as $sKey => $sVal) {
            $aGet[$sKey] = ($aError->has($sKey)) ?  '' : $aParam[$sKey];
            if ($sKey == 'c') {
                $aSearch[$aReplace[$sKey]] = $aGet[$sKey] != '' ? array($aGet[$sKey]) : array($aCity[0]);
            } else {
                $aSearch[$aReplace[$sKey]] = $aGet[$sKey];
            }
        }
        $aInfo = $this->oModel->getAll($aSearch);

        return array('info' => $aInfo, 'get' => $aGet, 'city' => $aCity, 'status' => $aStatus, 'area' => $aArea);
    }

}
