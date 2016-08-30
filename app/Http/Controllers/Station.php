<?php
/**
 * 取得場站資料
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repository\External\TaichungStation as TaipeiRepository;
use App\Repository\External\TaipeiStation as TaichungRepository;
use App\Repository\Station as StationRepository;

class Station extends Controller
{
    protected $oTaipei;
    protected $oTaichung;
    protected $oStation;

    public function __construct(StationRepository $StationRepository, TaipeiRepository $PeiRepository, TaichungRepository $ChungRepository)
    {
        $this->oStation = $StationRepository;
        $this->oTaipei = $PeiRepository;
        $this->oTaichung = $ChungRepository;
    }

    /**
     * 首頁
     * @return object [樣版輸出]
     */
    public function index()
    {
        $aInfo = $aDay = $aError = array();
        for ($i = 0 ; $i <= 23 ; $i++) {
            $aDay[$i] = array('min' => 0, 'max' => 0);
        }
        $this->oStation->where('_id', '!=', '')->delete();

        $aTaipeiInfo = $this->oTaipei->getAll();
        foreach($aTaipeiInfo as $aVal) {
            $sCity = $this->getCity($aVal['SxPSNo']);
            if  ((($aVal['SxPSEmpty'] == 0 && $aVal['ParkFDate'] != '') || $aVal['SxPSEmpty'] != 0 ) && time() > strtotime($aVal['StartDate']) && $sCity != '' && $aVal['SxPSName'] != '' && $aVal['Lat'] != 0 && !strpos($aVal['SxPSName'], '@')) {
                $aVal['city'] = $sCity;
                $aVal['day'] = $aDay;
                $this->oStation->create($this->handleParam($aVal));
            } else {
                $aError[] = array('station_no' => $aVal['SxPSNo'], 'station_name' => $aVal['SxPSName']);
            }
        }

        $aTaichungInfo = $this->oTaichung->getAll();
        foreach($aTaichungInfo as $aVal) {
            $sCity = $this->getCity($aVal['SxPSNo']);
            if ( (($aVal['SxPSEmpty'] == 0 && $aVal['ParkFDate'] != '') || $aVal['SxPSEmpty'] != 0 ) && time() > strtotime($aVal['StartDate']) && $sCity != '' && $aVal['SxPSName'] != '' && $aVal['Lat'] != 0 && !strpos($aVal['SxPSName'], '@')) {
                $aVal['city'] = $sCity;
                $aVal['day'] = $aDay;
                $this->oStation->create($this->handleParam($aVal));
            } else {
                $aError[] = array('station_no' => $aVal['SxPSNo'], 'station_name' => $aVal['SxPSName']);
            }
        }
        echo '<meta charset="utf-8">';
        echo '<pre>';
        print_r('get station finish');
        echo '<hr/>';
        print_r($aError);
        exit;
    }


    /**
     * 取得city名稱
     * @param  [type] $sSNo [description]
     * @return [type]       [description]
     */
    private function getCity($sSNo)
    {
        $sResult = '';
        $aCity = array(
            'Taipei'    => array('min' => 0, 'max' => 999),
            'NewTaipei' => array('min' => 1001, 'max' => 1999),
            'Taichung'  => array('min' => 3001, 'max' => 3999),
            'Changhua'  => array('min' => 7001, 'max' => 7399)
        );

        foreach ($aCity as $sCity => $aVal)
        {
            if ($sSNo >= $aVal['min'] && $sSNo <= $aVal['max'])
            {
                $sResult = $sCity;
                break;
            }
        }
        return $sResult;
    }

    private function handleParam($aVal)
    {
        $sStr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $sLength = strlen($sStr);
        if ($aVal['SxPSVer'] != 1) {
            $sImg = 'bface.png';
        } elseif ($aVal['SxPSEmpty'] == 0) {
            $sImg = 'rface.png';
        } elseif ($aVal['SxPSBiks'] == 0) {
            $sImg = 'yface.png';
        } else {
            $sImg = 'gface.png';
        }

        return array(
                'city'            => $aVal['city'],
                'station_no'      => $aVal['SxPSNo'],
                'station_name'    => ($aVal['SxPSVer'] == '1' ) ? str_replace('@', '', $aVal['SxPSName']) : $aVal['SxPSName'],
                'station_status'  => (int) ($aVal['SxPSVer'] != '1' ? 2 : 1),
                'station_lat'     => (Double)$aVal['Lat'],
                'station_lng'     => (Double)$aVal['Lng'],
                'total_space'     => $aVal['SxPSTot'],
                'empty_space'     => $aVal['SxPSEmpty'],
                'bike_station'    => $aVal['SxPSBiks'],
                'bike_breakdown'  => 0,
                'bike_rope'       => 0,
                'space_full_time' => (strtotime($aVal['ParkFDate']) != false) ? strtotime($aVal['ParkFDate']) : '',
                //'space_full_time' => $aVal['ParkFDate'],
                'no_bike_time'    => (strtotime($aVal['LackCDate']) != false) ? strtotime($aVal['LackCDate']) : '',
                'modify_date'     => (strtotime($aVal['ModifyDate']) != false) ? strtotime($aVal['ModifyDate']) : time(),
                'station_img'     => $sImg,
                'set_rope'        => rand(10, 30),
                'set_normalday'   => $aVal['day'],
                'set_weekday'     => $aVal['day'],
                'set_area'        => $sStr[rand(0, $sLength - 1)],
                'modify_user'     => 'System'
        );
    }

}
