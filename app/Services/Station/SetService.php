<?php
/* 邏輯 - 場站調度設定 */
namespace App\Services\Station;

use App\Repository\Station as Repository;
use Validator;
use Auth;
use Config;
use Lang;
use Website;
use Excel;

class SetService
{
    protected $oModel;
    private $aDay = [1 => 'normalday', 2 => 'weekday'];
    private $aDayImport = ['平日' => 'normalday', '假日' => 'weekday'];

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
        $aInfo = [];
        $aCity = Auth::user()->city;
        /* 取資料 */
        $aHandle = $this->handleParam($aCity, $aParam);
        $aInfo = $this->oModel->getDaySetList($aHandle['where']);
        /* 回傳 */
        return ['info' => $aInfo, 'get' => $aHandle['get'], 'city' => $aCity, 'day' => $this->aDay];
    }

    /**
     * 下載資料匯出
     * @param  \Illuminate\Http\Request  $request
     */
    public function download(array $aParam = array())
    {
        /* 取資料 */
        $aHandle = $this->handleParam(Auth::user()->city, $aParam);
        $aInfo = $this->oModel->getDaySetAll($aHandle['where']);
        Excel::create(Lang::get('website.data_example'), function($excel) use($aInfo) {
            $excel->sheet(Lang::get('website.data_example'), function($sheet) use($aInfo) {
                $aHead = [Lang::get('website.station_no'), Lang::get('website.date_type')];
                for ($i = 0 ; $i <= 23 ; $i++) {
                    $aHead[] = sprintf('%02d', $i).Lang::get('website.num_min');
                    $aHead[] = sprintf('%02d', $i).Lang::get('website.num_max');
                }
                $sheet->prependRow(1, $aHead);
                $iRow = 1;
                foreach ($aInfo as $aVal) {
                    foreach(['normalday', 'weekday'] as $sDay) {
                        $aTempRow = [$aVal['station_no'], Lang::get('website.'.$sDay)];
                        foreach($aVal['set_'.$sDay] as $aChild) {
                            $aTempRow[] = $aChild['min'];
                            $aTempRow[] = $aChild['max'];
                        }
                        $sheet->row(++$iRow, $aTempRow);
                    }
                }
                $sheet->setFontSize(12)->setAutoSize(true);
            });
        })->download('xls');
    }

    /**
     * 修改資料
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function edit(array $aParam = array())
    {
        try {
            /* 驗證資料 */
            if (count(Validator::make($aParam, ['item' => 'required'])->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            $aSave = [];
            foreach (json_decode($aParam['item']) as $oVal) {
                $aSave[$oVal->sno]['set_'.$oVal->day_type][$oVal->hour][$oVal->set_type] = (int)$oVal->set;
            }
            /* 開始更新資料 */
            foreach ($aSave as $sStationNo => $aVal) {
                $this->oModel->updateDaySet((string)$sStationNo, array_merge([
                        'set_normalday' => $aVal['set_normalday'],
                        'set_weekday'   => $aVal['set_weekday']
                    ], Website::getSaveInfo('edit')));
            }
            /* 回傳 */
            return [
                'result'   => true,
                'message'  => Lang::get('back.s_edit_data'),
                'redirect' => Website::getRedirect($aParam, $aParam['default_url'])
            ];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 匯入資料
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function import(array $aParam = array())
    {
        try {
            /* 驗證資料 */
            if (count(Validator::make($aParam, ['upload_excel' => Config::get('validator.excel')])->errors()->all()) > 0 ||
                ValidatorFile::checkExcel($aParam['upload_excel']) != true ||
                $aParam['upload_excel']->isValid() != true) {
                throw new \Exception(Lang::get('back.f_import_format'));
            }
            $oExcel = Excel::load($aParam['upload_excel']);
            $aExcel = $oExcel->getSheet(0)->toArray();
            unset($aExcel[0]);
            /* 整理要更新的資料 */
            $aArea = $this->AreaModel->getArea()->toArray();
            $aSave = [];
            foreach ($aExcel as $aVal) {
                if ($aVal[0] != '') {
                    $sTemp = 'set_'.$this->aDayImport[$aVal[1]];
                    $iIndex = 1;
                    for($iHour = 0 ; $iHour <= 23 ; $iHour++) {
                        $aSave[$aVal[0]][$sTemp][$iHour]['min'] = $aVal[++$iIndex];
                        $aSave[$aVal[0]][$sTemp][$iHour]['max'] = $aVal[++$iIndex];
                    }
                }
            }
            dd($aSave);
            /* 開始更新資料 */
            foreach ($aTemp as $sUsername => $aArea) {
                $this->oModel->importUpdate(array_merge(['area' => $aArea], Website::getSaveInfo('edit')), $sUsername);
            }
            /* 回傳 */
            return [
                'result'   => true,
                'message'  => Lang::get('back.s_import_data'),
                'redirect' => $aParam['default_url']
            ];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 處理參數
     * @param  array  $aCity
     * @param  array  $aParam
     * @return array
     */
    private function handleParam(array $aCity = array(), array $aParam = array())
    {
        return Website::handleGet([
            'get'     => $aParam,
            'format'  => [
                'no'  => Config::get('validator.station_no'),
                'c'   => Config::get('validator.city').implode('","', $aCity).'"',
                'day' => 'required|in:"'.implode('","', array_keys($this->aDay)).'"',
            ],
            'replace' => ['c' => 'city', 'no' => 'station_no', 'day' => 'set_weekday'],
            'city'    => $aCity
        ]);
    }
}
