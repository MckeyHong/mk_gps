<?php
/**
 * 場站資料
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class Station extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'station';
    protected $fillable = ['city',
                           'station_no',
                           'station_name',
                           'station_status',
                           'station_lat',
                           'station_lng',
                           'total_space',
                           'empty_space',
                           'bike_station',
                           'bike_breakdown',
                           'bike_rope',
                           'space_full_time',
                           'no_bike_time',
                           'station_img',
                           'set_rope',
                           'set_normalday',
                           'set_weekday',
                           'set_area',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
}
