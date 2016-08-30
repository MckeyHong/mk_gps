<?php
/**
 * 地方區域設定
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class GpsArea extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'gps_area';
    protected $fillable = ['city',
                           'belong_station',
                           'belong_area',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
    protected $hidden = ['create_date', 'create_user', 'modify_date', 'modify_user'];
}
