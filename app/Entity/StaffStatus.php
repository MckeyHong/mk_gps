<?php
/**
 * 人員狀態資料
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class StaffStatus extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'staff_status';
    protected $fillable = ['status_name',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
    protected $hidden = ['create_date', 'create_user', 'modify_date', 'modify_user'];
}
