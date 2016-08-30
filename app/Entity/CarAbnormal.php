<?php
/**
 * 車輛檢查異常資料
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class CarAbnormal extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'car_abnormal';
    protected $fillable = ['car_id',
                           'car_no',
                           'car_brand_id',
                           'brand_name',
                           'check_item',
                           'check_img',
                           'create_date',
                           'create_user',
                           'create_user_no'];
    protected $guarded = ['_id'];
}
