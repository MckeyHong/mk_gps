<?php
/**
 * 商業邏輯 - 車輛檢查異常
 */
namespace App\Services\Car;

use App\Repository\CarAbnormal as Repository;
use Validator;
use Config;

class CheckAbnormalService
{
    protected $oModel;

    public function __construct(Repository $Model)
    {
        $this->oModel = $Model;
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
        $aReplace = array('car' => 'car_no', 'date' => 'date');

        /* 驗證查詢參數是否正確 */
        $aFormat = array(
            'car'   => 'required|max:20',
            'date'  => 'required|date|date_format:Y-m-d',
        );

        $aError = Validator::make($aParam, $aFormat)->messages();
        foreach ($aFormat as $sKey => $sVal) {
            if ($sKey == 'date') {
                $aGet['date'] = ($aError->has('date')) ?  date('Y-m-d') : $aParam['date'];
                $aSearch['start'] = strtotime($aGet['date'].' 00:00:00');
                $aSearch['end'] = strtotime($aGet['date'].' 23:59:59');
            } else {
                $aGet[$sKey] = ($aError->has($sKey)) ?  '' : $aParam[$sKey];
                $aSearch[$aReplace[$sKey]] = $aGet[$sKey];
            }
        }
        $aSearch['per_page'] = Config::get('website.per_page');
        $aInfo = $this->oModel->getList($aSearch);
        /* 處理顯示資訊 */
        foreach ($aInfo as $iKey => $aVal) {
            $aInfo[$iKey]['check_item'] = implode(',', $aVal['check_item']);
            //$aInfo[$iKey]['check_img'] = base64_decode($aVal['check_img']);
        }

        return array('info' => $aInfo, 'get' => $aGet);
    }

}
