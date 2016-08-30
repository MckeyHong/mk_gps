<?php
namespace App\Entity;

use Jenssegers\Mongodb\Model as Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /* connection、collection setting */
    protected $connection = 'mongodb';
    protected $table = 'users';
    /* 定義可以透過Mass Assignment來寫入/更新資料($guarded的相反) */
    protected $fillable = ['username',
                           'password',
                           'enable_type',
                           'users_name',
                           'role_id',
                           'dept_id',
                           'city',
                           'area',
                           'work_notice',
                           'work_keynote',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];

    /* 定義可以透過Mass Assignment不可寫入/更新資料($fillable的相反) */
    protected $guarded = ['_id'];
    /* 轉換成陣列或 JSON 時隱藏屬性 */
    protected $hidden = ['password', 'api_key', 'remember_token'];
}
