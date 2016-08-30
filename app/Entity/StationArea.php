<?php
/**
 * 場站工作區域資料
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class StationArea extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'station_area';
    protected $fillable = ['area_name',
                           'staff',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
    protected $hidden = ['create_date', 'create_user', 'modify_date', 'modify_user'];
}
