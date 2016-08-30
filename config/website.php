<?php
/**
 * 網站相關設定檔
 */
return [
    'language'     => ['tw' => '繁體中文'], /* 系統語系設定 */
    'per_page'     => 15, /* 一頁顯示數量 */
    'single_login' => false, /* 限制一個帳號只能單人使用(true：開啟、false：關閉) */
    'privilege'    => false, /* 是否開啟功能權限(true：開啟、false：關閉) */
    'layout'       => 'layouts.',
    'city'         => ['Taipei', 'NewTaipei', 'Taoyuan', 'Taichung', 'Changhua'],
    'import_limit' => '2097152', /* 上傳檔案限制(bytes) vaildator要一併修改 */
    'excel_mimes'  => 'application/vnd.ms-office', /* 上傳檔案支援格式 */
    'super_user'   => ['admin'],
    'station_status' => [1, 2],
];
