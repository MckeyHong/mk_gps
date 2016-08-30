<?php
/**
 * 例行派工設定
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class WorkAllocation extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'work_allocation';
    protected $fillable = ['city',
                           'car_id',
                           'car_no',
                           'pilot',
                           'steward',
                           'keynote',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
    protected $hidden = ['create_date', 'create_user', 'modify_date', 'modify_user'];
}
