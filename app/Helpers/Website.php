<?php
/* 系統常用函數 */
namespace App\Helpers;

use Validator;
use Config;
use Auth;

class Website
{
    /**
     * 取得導頁資料
     * @param  array    $aParam
     * @param  string   $sDefaultUrl
     * @return string
     */
    public static function getRedirect(array $aParam = array(), $sDefaultUrl = '')
    {
        if (count(Validator::make($aParam, array('_redirect' => 'required|url'))->errors()->all()) == 0) {
            return $aParam['_redirect'];
        } else {
            return $sDefaultUrl;
        }
    }

    /**
     * 處理列表Get參數
     * @param  array  $aParam
     * @return array
     */
    public static function handleGet(array $aParam = array())
    {
        $aGet = $aWhere = array();
        $aError = Validator::make($aParam['get'], $aParam['format'])->messages();
        foreach ($aParam['format'] as $sKey => $sVal) {
            $aGet[$sKey] = ($aError->has($sKey)) ?  '' : $aParam['get'][$sKey];
            if ($sKey == 'c') {
                $aWhere[$aParam['replace'][$sKey]] = $aGet[$sKey] != '' ? array($aGet[$sKey]) : $aParam['city'];
            } else {
                $aWhere[$aParam['replace'][$sKey]] = $aGet[$sKey];
            }
        }
        $aWhere['per_page'] = Config::get('website.per_page');
        return ['get' => $aGet, 'where' => $aWhere];
    }

    /**
     * 取得資料要儲存的共同資訊(Ex.時間、人員)
     * @param  string $sType
     * @return array
     */
    public static function getSaveInfo($sType = '')
    {
        $sTime = time();
        switch ($sType) {
            case 'edit':
                return [
                    'modify_date' => $sTime,
                    'modify_user' => Auth::user()->_id
                ];
                break;
            default:
                return [
                    'create_date' => $sTime,
                    'create_user' => Auth::user()->_id,
                    'modify_date' => $sTime,
                    'modify_user' => Auth::user()->_id
                ];
            break;
        }
    }

}
