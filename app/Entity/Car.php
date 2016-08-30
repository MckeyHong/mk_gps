<?php
/**
 * 車輛資料
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class Car extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'car';
    protected $fillable = ['car_no',
                           'gps_id',
                           'gps_no',
                           'city',
                           'car_type_id',
                           'car_brand_id',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
    protected $hidden = ['create_date', 'create_user', 'modify_date', 'modify_user'];
}
