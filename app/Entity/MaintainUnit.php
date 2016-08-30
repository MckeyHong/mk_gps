<?php
/**
 * 車輛保修單位資料
 */
namespace App\Entity;

use Jenssegers\Mongodb\Model as Eloquent;

class MaintainUnit extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'maintain_unit';
    protected $fillable = ['unit_name',
                           'create_date',
                           'create_user',
                           'modify_date',
                           'modify_user'];
    protected $guarded = ['_id'];
    protected $hidden = ['create_date', 'create_user', 'modify_date', 'modify_user'];

}
