<?php
/**
 * 商業邏輯 - 載車相關記錄查詢
 */
namespace App\Services\Record;

use App\Repository\RecordCarCarry as Repository;
use Validator;
use Config;
use Lang;
use Excel;

class BikeCarryService
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
        $aReplace = array('car' => 'car_no', 'city' => 'city_name', 'start' => 'start', 'end' => 'end');
        $aCity = config::get('website.city');

        /* 驗證查詢參數是否正確 */
        $aFormat = array(
            'car'   => 'required|max:20',
            'start' => 'required|date|date_format:Y-m-d',
            'end'   => 'required|date|date_format:Y-m-d',
            'city'  => 'required|max:20|in:"'.implode('","', $aCity).'"'
        );
        if (isset($aParam['start']) && isset($aParam['end']) && $aParam['start'] > $aParam['end']) { /* 日期交換 */
            $sTemp = $aParam['end'];
            $aParam['end'] = $aParam['start'];
            $aParam['start'] = $sTemp;
        }

        $aError = Validator::make($aParam, $aFormat)->messages();
        foreach ($aFormat as $sKey => $sVal) {
            if (in_array($sKey, array('start', 'end'))) {
                $aGet[$sKey] = ($aError->has($sKey)) ?  date('Y-m-d') : $aParam[$sKey];
                $aSearch[$aReplace[$sKey]] = strtotime($aGet[$sKey].($sKey == 'start' ? ' 00:00:00' : ' 23:59:59'));
            } else {
                $aGet[$sKey] = ($aError->has($sKey)) ?  '' : $aParam[$sKey];
                $aSearch[$aReplace[$sKey]] = $aGet[$sKey];
            }
        }
        $aSearch['per_page'] = Config::get('website.per_page');
        $aInfo = $this->oModel->getList($aSearch);
        foreach ($aInfo as $iKey => $aVal) {
            $aInfo[$iKey]['create_date'] = date('Y-m-d', $aVal['create_date']);
            $aInfo[$iKey]['staff_info'] = implode(',', array_pluck($aVal['staff'], 'username'));
        }

        return array('info' => $aInfo, 'get' => $aGet, 'city' => $aCity);
    }

    /**
     * 資料匯出
     * @param  array  $aParam
     */
    public function export(array $aParam = array())
    {
        $aInfo = $this->getList($aParam);
        Excel::create(Lang::get('menu.record_bike_carry'), function($excel) use($aInfo) {
            $excel->sheet(Lang::get('website.data_export'), function($sheet) use($aInfo) {
                $iNo = 0;
                $sheet->prependRow(++$iNo, array(Lang::get('website.time'), Lang::get('website.city'), Lang::get('website.car_no'), Lang::get('website.staff_no'), Lang::get('website.carry_num')));
                foreach ($aInfo['info'] as $aVal) {
                    $sheet->row(++$iNo, array(
                        $aVal['create_date'],
                        $aVal['city_name'],
                        $aVal['car_no'],
                        $aVal['staff_info'],
                        $aVal['carry_num']
                    ));
                }
                $sheet->row(++$iNo, array(Lang::get('website.data_count').'：'.($iNo-2)));
                $sCity = ($aInfo['get']['city'] != '' && isset($aInfo['get']['city'])) ? $aInfo['get']['city'] : Lang::get('website.all');

                $sheet->row(++$iNo, array(
                    Lang::get('website.city').'：'.$sCity.'、'.
                    Lang::get('website.car_no').'：'.$aInfo['get']['car'].'、'.
                    Lang::get('website.time').'：'.$aInfo['get']['start'].' ~ '.$aInfo['get']['end']
                ));
                $sheet->mergeCells('A'.$iNo.':E'.$iNo);

                $sheet->setFontSize(12)->setAutoSize(true);
            });
        })->download('xls');
    }

}
