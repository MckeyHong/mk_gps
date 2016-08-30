<?php
/**
 * 車輛相關記錄查詢
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class RecordCarCarry extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'record_car_carry';
    protected $fillable = ['car_id',
                           'car_no',
                           'carry_num',
                           'staff',
                           'create_date'];
    protected $guarded = ['_id'];
}
