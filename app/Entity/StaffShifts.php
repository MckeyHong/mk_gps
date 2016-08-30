<?php
/**
 * 人員班別資訊
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class StaffShifts extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'staff_shifts';
    protected $fillable = ['user_id',
                           'shift_date',
                           'shift_name',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
    protected $hidden = ['create_date', 'create_user', 'modify_date', 'modify_user'];
}
