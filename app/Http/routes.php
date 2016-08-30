<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/cron_station', 'Station@index');

/* 首頁 */
Route::group(['middleware' => array('auth', 'xss', 'privilege')], function () {
    Route::get('/', 'home@index');
    Route::get('/home', 'home@index');

    /* 管理者設定 */
    Route::group(['prefix' => 'Admin', 'namespace' => 'Admin'], function() {
        /* 管理者資料 */
        Route::get('Info', 'Info@index');
        Route::get('Info/Add', 'Info@create');
        Route::get('Info/Edit/{id}', 'Info@edit');
        Route::post('Info/ChangePwd', 'Info@changePwd');

        /* 角色設定 */
        Route::get('Privilege', 'Privilege@index');
        Route::get('Privilege/Add', 'Privilege@create');
        Route::post('Privilege/Add', 'Privilege@store');
        Route::get('Privilege/Edit/{id}', 'Privilege@edit');
        Route::post('Privilege/Edit/{id}', 'Privilege@update');
        Route::delete('Privilege/{id}', 'Privilege@destroy');
        Route::post('Privilege/DeleteMulti', 'Privilege@destroyMulti');

        /* 組織部門 */
        Route::get('Dept', 'Dept@index');
        Route::post('Dept', 'Dept@store');
        Route::put('Dept', 'Dept@update');
        Route::delete('Dept/{id}', 'Dept@destroy');
        Route::post('Dept/DeleteMulti', 'Dept@destroyMulti');
    });

    /* GPS設備管理 */
    Route::group(['prefix' => 'Gps', 'namespace' => 'Gps'], function() {
        /* GPS設定 */
        Route::get('Set', 'Set@index');
        Route::post('Set', 'Set@store');
        Route::put('Set', 'Set@update');
        Route::delete('Set/{id}', 'Set@destroy');
        Route::post('Set/DeleteMulti', 'Set@destroyMulti');

        /* 車輛配置設定 */
        Route::get('Car', 'Car@index');
        Route::post('Car', 'Car@store');
        Route::put('Car', 'Car@update');
        Route::delete('Car/{id}', 'Car@destroy');
        Route::post('Car/DeleteMulti', 'Car@destroyMulti');

        /* GPS資訊狀態 */
        Route::get('Info', 'Info@index');

        /* 地方區域設定 */
        Route::get('Area', 'Area@index');
        Route::post('Area', 'Area@store');
        Route::put('Area', 'Area@update');
        Route::delete('Area/{id}', 'Area@destroy');
        Route::post('Area/DeleteMulti', 'Area@destroyMulti');

        /* 車輛種類設定 */
        Route::get('CarType', 'CarType@index');
        Route::post('CarType', 'CarType@store');
        Route::put('CarType', 'CarType@update');
        Route::delete('CarType/{id}', 'CarType@destroy');
        Route::post('CarType/DeleteMulti', 'CarType@destroyMulti');
    });


    /* 地圖管理 */
    Route::group(['prefix' => 'Map', 'namespace' => 'Map'], function() {
        /* 地圖狀態顯示 */
        Route::get('Info', 'Info@index');
        Route::get('UpdateStation', 'Info@updateStation');
    });

    /* 車輛管理 */
    Route::group(['prefix' => 'Car', 'namespace' => 'Car'], function() {
        /* 車輛相關資訊 */
        Route::get('Info', 'Info@index');

        /* 車輛限速設定 */
        Route::get('Speed', 'Speed@index');
        Route::put('Speed', 'Speed@update');

        /* 車輛保修紀錄 */
        Route::get('Maintain', 'Maintain@index');
        Route::get('Maintain/Detail/{id}', 'Maintain@detail');

        /* 車輛軌跡紀錄 */
        Route::get('Locus', 'Locus@index');

        /* 車輛檢查設定 */
        Route::get('CheckSet', 'CheckSet@index');
        Route::post('CheckSet', 'CheckSet@store');
        Route::put('CheckSet', 'CheckSet@update');
        Route::delete('CheckSet/{id}', 'CheckSet@destroy');
        Route::post('CheckSet/DeleteMulti', 'CheckSet@destroyMulti');

        /* 車輛檢查異常 */
        Route::get('CheckAbnormal', 'CheckAbnormal@index');
    });

    /* 工作管理 */
    Route::group(['prefix' => 'Work', 'namespace' => 'Work'], function() {
        /* 工作區域設定 */
        Route::get('Area', 'Area@index');
        Route::put('Area', 'Area@update');
        Route::post('Area', 'Area@store');

        /* 工作班別設定 - 值勒人員資訊(預設畫面) */
        Route::get('Shift', 'Shift@index');
        Route::post('Shift/StaffShifts', 'Shift@getStaffShifts');

        /* 工作班別設定 - 班表設定 */
        Route::get('Shift/Staff', 'ShiftStaff@index');
        /* 工作班別設定 - 班表設定 */
        Route::get('Shift/Set', 'ShiftSet@index');
        Route::post('Shift/Set', 'ShiftSet@store');
        Route::put('Shift/Set', 'ShiftSet@update');
        Route::delete('Shift/Set/{id}', 'ShiftSet@destroy');
        Route::post('Shift/Set/DeleteMulti', 'ShiftSet@destroyMulti');

        /* 人員績效資訊 */
        Route::get('StaffResults', 'StaffResults@index');

        /* 人員狀態資訊 */
        Route::get('StaffInfo', 'StaffInfo@index');

        /* 人員匯域設定 */
        Route::get('StaffArea', 'StaffArea@index');
        Route::put('StaffArea', 'StaffArea@update');
        Route::get('StaffArea/Demo', 'StaffArea@download');
        Route::post('StaffArea/Import', 'StaffArea@import');

        /* 人員狀態設定 */
        Route::get('StaffStatus', 'StaffStatus@index');
        Route::post('StaffStatus', 'StaffStatus@store');
        Route::put('StaffStatus', 'StaffStatus@update');
        Route::delete('StaffStatus/{id}', 'StaffStatus@destroy');
        Route::post('StaffStatus/DeleteMulti', 'StaffStatus@destroyMulti');

        /* 工作狀態設定 */
        Route::get('Status', 'Status@index');
        Route::post('Status', 'Status@store');
        Route::put('Status', 'Status@update');
        Route::delete('Status/{id}', 'Status@destroy');
        Route::post('Status/DeleteMulti', 'Status@destroyMulti');

        /* 例行派工設定 */
        Route::get('Allocation', 'Allocation@index');
        Route::post('Allocation', 'Allocation@store');
        Route::put('Allocation', 'Allocation@update');
        Route::post('Allocation/Clear', 'Allocation@clear');
        Route::post('Allocation/ClearMulti', 'Allocation@clearMulti');
        Route::get('Allocation/Demo', 'Allocation@download');
        Route::post('Allocation/Import', 'Allocation@import');

        /* 鎖頭資訊 */
        Route::get('Rope', 'Rope@index');
        Route::post('Rope', 'Rope@store');
        Route::put('Rope', 'Rope@update');
        Route::delete('Rope/{id}', 'Rope@destroy');
        Route::post('Rope/DeleteMulti', 'Rope@destroyMulti');
        Route::post('Rope/ReturnMulti', 'Rope@returnMulti');
    });

    /* 場站管理 */
    Route::group(['prefix' => 'Station', 'namespace' => 'Station'], function() {
        /* 場站狀態資訊 */
        Route::get('Status', 'Status@index');
        /* 場站調度設定 */
        Route::get('Set', 'Set@index');
        Route::put('Set', 'Set@update');
        Route::get('Set/Demo', 'Set@download');
        Route::post('Set/Import', 'Set@import');

        /* 場站綁車資訊 */
        Route::get('Rope', 'Rope@index');
    });

    /* 報表管理 */
    Route::group(['prefix' => 'Record', 'namespace' => 'Record'], function() {
        /* 綁車相關記錄查詢 */
        Route::get('BikeRope', 'BikeRope@index');
        /* 載車相關記錄查詢 */
        Route::get('BikeCarry', 'BikeCarry@index');
        Route::get('BikeCarry/Export', 'BikeCarry@export');

        /* 場站狀態記錄查詢 */
        Route::get('StationStatus', 'StationStatus@index');
        /* 場站處理記錄查詢 */
        Route::get('StationHandle', 'StationHandle@index');
        /* 車輛相關記錄查詢 */
        Route::get('Car', 'Car@index');
        /* 人員狀態記錄查詢 */
        Route::get('StaffStatus', 'StaffStatus@index');
        /* 人員績效記錄查詢 */
        Route::get('StaffResults', 'StaffResults@index');
        /* 車輛檢查記錄查詢 */
        Route::get('CarCheck', 'CarCheck@index');
    });
});

/* 系統登入 */
Route::controllers([
    'auth' => 'Auth\AuthController',
]);
