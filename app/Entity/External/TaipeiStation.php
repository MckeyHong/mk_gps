<?php
/**
 * 台北場站資料
 */
namespace App\Entity\External;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TaipeiStation extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'sqlsrv_taipei';
    protected $table = 'spara';
    protected $guarded = [];
}
