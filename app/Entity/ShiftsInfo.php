<?php
/**
 * 班表設定
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class ShiftsInfo extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'shifts_info';
    protected $fillable = ['shift_name',
                           'shift_start_time',
                           'shift_end_time',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
    protected $hidden = ['create_date', 'create_user', 'modify_date', 'modify_user'];
}
