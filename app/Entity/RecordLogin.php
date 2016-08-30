<?php
/**
 * 系統登入紀錄
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class RecordLogin extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'record_login';
    protected $fillable = ['login_username',
                           'login_type',
                           'login_ip',
                           'create_date'];
    protected $guarded = ['_id'];
}
