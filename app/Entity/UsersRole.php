<?php
/**
 * 角色資料
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class UsersRole extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'users_role';
    protected $fillable = ['role_name',
                           'role_privilege',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
}
