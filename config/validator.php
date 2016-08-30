<?php
/* 驗證 */
return [
    'id'             => 'required|alpha_num|min:24|max:24',
    'city'           => 'required|max:20|in:"',
    'rope'           => 'required|max:20',
    'acc'            => 'required|alpha_num|min:4|max:15',
    'excel'          => 'required|max:2048', /* website.php要一併修改 */
    'status'         => 'required|max:20',
    'car_type'       => 'required|max:20',
    'role'           => 'required|max:20',
    'belong_station' => 'required|max:20',
    'belong_area'    => 'required|max:20',
    'station_area'   => 'required|alpha_num|max:10',
    'gps_no'         => 'required|max:20',
    'car_no'         => 'required|max:20',
    'car_band'       => 'required|max:20',
    'station_no'     => 'required|alpha_num|max:10',
];
