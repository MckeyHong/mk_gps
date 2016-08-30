<?php
/**
 * 車輛速度設定
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class CarSpeed extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'car_speed';
    protected $fillable = ['road_type',
                           'speed_min',
                           'speed_max',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
    protected $hidden = ['create_date', 'create_user', 'modify_date', 'modify_user'];
}
