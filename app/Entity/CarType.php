<?php
/**
 * 車輛種類資料
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class CarType extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'car_type';
    protected $fillable = ['car_type',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
    protected $hidden = ['create_date', 'create_user', 'modify_date', 'modify_user'];
}
