<?php
/**
 * 系統功能目錄相關
 */
namespace App\Helpers;

use Request;
use Lang;
use Auth;
use Config;

class Menu
{
    /* 目前所在功能標題 */
    private static $sTitle = '';
    /* 系統功能設定 */
    private static $aMenu = array(
        /* 管理者資料 */
        'Admin' => array(
            'title' => 'admin',
            'icon'  => 'fa-user',
            'child' => array(
                'Info'      => array('title' => 'admin_info'),
                'Privilege' => array('title' => 'admin_privilege'),
                'Dept'      => array('title' => 'admin_dept')
            )
        ),
        /* GPS設定 */
        'Gps' => array(
            'title' => 'gps',
            'icon'  => 'fa-dashboard',
            'child' => array(
                'Set'     => array('title' => 'gps_set'),
                'Car'     => array('title' => 'gps_car'),
                'Info'    => array('title' => 'gps_info'),
                'Area'    => array('title' => 'gps_area'),
                'CarType' => array('title' => 'gps_car_type')
            ),
        ),
        /* 地圖管理 */
        'Map' => array(
            'title' => 'map',
            'icon'  => 'fa-user',
            'child' => array(
                'Info' => array('title' => 'map_info')
            ),
        ),
        /* 車輛管理 */
        'Car' => array(
            'title' => 'car',
            'icon'  => 'fa-car',
            'child' => array(
                'Info'          => array('title' => 'car_info'),
                'Speed'         => array('title' => 'car_speed'),
                'Maintain'      => array('title' => 'car_maintain'),
                'Locus'         => array('title' => 'car_locus'),
                'CheckSet'      => array('title' => 'car_check_set'),
                'CheckAbnormal' => array('title' => 'car_check_abnormal')
            ),
        ),
        /* 工作管理 */
        'Work' => array(
            'title' => 'work',
            'icon'  => 'fa-users',
            'child' => array(
                'Area'         => array('title' => 'work_area'),
                'Shift'        => array('title' => 'work_shift'),
                'StaffResults' => array('title' => 'work_staff_results'),
                'StaffInfo'    => array('title' => 'work_staff_info'),
                'StaffArea'    => array('title' => 'work_staff_area'),
                'StaffStatus'  => array('title' => 'work_staff_status'),
                'Status'       => array('title' => 'work_status'),
                'Allocation'   => array('title' => 'work_allocation'),
                'Rope'         => array('title' => 'work_rope')
            ),
        ),
        /* 場站管理 */
        'Station'  => array(
            'title' => 'station',
            'icon'  => 'fa-bicycle',
            'child' => array(
                'Status' => array('title' => 'station_status'),
                'Set'    => array('title' => 'station_set'),
                'Rope'   => array('title' => 'station_rope')
            ),
        ),
        /* 報表查詢 */
        'Record' => array(
            'title' => 'record',
            'icon'  => 'fa-bar-chart',
            'child' => array(
                'BikeRope'      => array('title' => 'record_bike_rope'),
                'BikeCarry'     => array('title' => 'record_bike_carry'),
                'StationStatus' => array('title' => 'record_station_status'),
                'StationHandle' => array('title' => 'record_station_handle'),
                'Car'           => array('title' => 'record_car'),
                'StaffStatus'   => array('title' => 'record_staff_status'),
                'StaffResults'  => array('title' => 'record_staff_results'),
                'CarCheck'      => array('title' => 'record_car_check')
            )
        )
    );

    /**
     * 取得系統左側要顯示的功能列表
     * @return array
     */
    public static function getSidebarMenu()
    {
        $aMenu = self::$aMenu;
        $aRolePrivilege = Auth::user()->RolePrivilege;
        if (Config::get('website.privilege') == true) {
            foreach ($aMenu as $sKey => $aVal) {
                foreach($aVal['child'] as $sChildKey => $aChildVal) {
                    if (!in_array($sKey.'/'.$sChildKey, $aRolePrivilege)) {
                        unset($aMenu[$sKey]['child'][$sChildKey]);
                    }
                }
                if (count($aMenu[$sKey]['child']) == 0) {
                    unset($aMenu[$sKey]);
                }
            }
        }
        return $aMenu;
    }

    /**
     * 取得所有系統的功能目錄
     * @return array
     */
    public static function getAllMenu()
    {
        return self::$aMenu;
    }

    /**
     * 取得功能目錄
     * @return string
     */
    public static function getMenuTitle()
    {
        if(self::$sTitle == '') {
            $aTemp = explode('/', Request::path());
            $iTemp = (count($aTemp) > 2) ? 2 : count($aTemp);
            $sLang = '';
            for ($iNo = 0 ; $iNo < $iTemp ; $iNo++) {
                $sLang .= ($sLang != '') ? '_'. strtolower($aTemp[$iNo]) : strtolower($aTemp[$iNo]);
            }
            self::$sTitle = (Lang::has('menu.'.$sLang)) ? Lang::get('menu.' . $sLang) : Lang::get('menu.home');
            if (count($aTemp) > 2) {
                if($aTemp[1] == 'Shift') {
                    self::$sTitle = Lang::get('menu.work_shift_'.strtolower($aTemp[2]));
                } else {
                    $sTempHead = '';
                    if (Request::is('*/Detail/*')) {
                        $sTempHead = Lang::get('website.detail_data');
                    } elseif (Request::is('*/Edit/*')) {
                        $sTempHead = Lang::get('website.edit_data');
                    } elseif (Request::is('*/Add/*')) {
                        $sTempHead = Lang::get('website.add_data');
                    }
                    self::$sTitle = $sTempHead.self::$sTitle;
                }
            }
        }
        return self::$sTitle;
    }

    /**
     * 取得麵包屑
     * @return array
     */
    public static function getBreadcrumbs()
    {
        $aTemp = explode('/', Request::path());
        $iTemp = count($aTemp);
        if( isset($aTemp[0]) && $aTemp[0] != '' ) {
            foreach ( $aTemp as $iKey => $sPath ) {
                $sLang = $sUrl = '';
                for ($iNo = 0 ; $iNo <= $iKey ; $iNo++) {
                    $sLang .= ($sLang != '') ? '_'. strtolower($aTemp[$iNo]) : strtolower($aTemp[$iNo]);
                    $sUrl  .= '/'. $aTemp[$iNo];
                }

                $sTitle = Lang::get('menu.'.$sLang);
                if ($iKey == 2) {
                    if($aTemp[1] == 'Shift') {
                        $sTitle = Lang::get('menu.work_shift_'.strtolower($aTemp[2]));
                    } else {
                        $sTempHead = '';
                        if (Request::is('*/Detail/*')) {
                            $sTempHead = Lang::get('website.detail_data');
                        } elseif (Request::is('*/Edit/*')) {
                            $sTempHead = Lang::get('website.edit_data');
                        } elseif (Request::is('*/Add/*')) {
                            $sTempHead = Lang::get('website.add_data');
                        }
                        $sTitle = $sTempHead.$aPath[$iKey-1]['title'];
                    }
                }

                $aPath[] = array(
                    'title' => $sTitle,
                    'url'   => ( in_array($iKey, array(0, 2)) && ($iKey+1) != $iTemp) ? '' : $sUrl,
                    'last'  => (($iKey+1) == $iTemp) ? true : false
                );
                if ($iKey == 2) {
                    break;
                }
            }
        } else {
            $aPath = array(
                0 => array(
                    'title' => Lang::get('menu.home'),
                    'url'   => '',
                    'last'  => true
            ));
        }
        return $aPath;
    }

    /**
     * 取得工作班表的子功能目錄
     * @return array
     */
    public static function getWorkShiftMenu()
    {
        return array(
            0 => array('url' => 'Work/Shift',       'title' => 'menu_shift_info'),
            1 => array('url' => 'Work/Shift/Staff', 'title' => 'menu_shift_staff'),
            2 => array('url' => 'Work/Shift/Set',   'title' => 'menu_shift_set')
        );
    }

}
