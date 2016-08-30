<?php
/**
 * 鎖頭資訊
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class Rope extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'rope';
    protected $fillable = ['city',
                           'rope_no',
                           'rope_status',
                           'staff_info',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
    protected $hidden = ['create_date', 'create_user', 'modify_date', 'modify_user'];
}
