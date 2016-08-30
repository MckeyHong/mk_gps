<?php
/**
 * 台中場站資料
 */
namespace App\Entity\External;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TaichungStation extends Eloquent
{
    public $timestamps = false;
    protected $connection = 'sqlsrv_taichung';
    protected $table = 'spara';
    protected $guarded = [];
}
