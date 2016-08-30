<?php
/**
 * 功能 - 車輛相關資訊
 */
namespace App\Http\Controllers\Car;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Car\InfoService as Service;

class Info extends Controller
{
    protected $oServices;

    public function __construct(Request $request, Service $Service)
    {
        parent::__construct($request);
        $this->oServices = $Service;
    }

    /**
     * 頁面：列表
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $aInfo = $this->oServices->getList($request->all());
        /* Layout */
        return view($this->layouts,[
            'aInfo' => $aInfo['info'],
            'aGet'  => $aInfo['get']
        ]);
    }

}
