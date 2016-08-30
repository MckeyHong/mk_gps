<?php
/**
 * 部門組織資料
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class UsersDept extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'users_dept';
    protected $fillable = ['city',
                           'level',
                           'sort',
                           'parent_id',
                           'parent_arr',
                           'dept_name',
                           'staff_info',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
}
