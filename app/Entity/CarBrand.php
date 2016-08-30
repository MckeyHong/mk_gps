<?php
/**
 * 車輛品牌資料
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class CarBrand extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'car_brand';
    protected $fillable = ['brand_name',
                           'check_item',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
    protected $hidden = ['create_date', 'create_user', 'modify_date', 'modify_user'];
}
