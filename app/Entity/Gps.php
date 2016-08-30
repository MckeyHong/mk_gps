<?php
/**
 * GPS設備資料
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class Gps extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'gps';
    protected $fillable = ['gps_no',
                           'cellphone',
                           'cellphone_provider',
                           'city',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
    protected $hidden = ['create_date', 'create_user', 'modify_date', 'modify_user'];
}
