<?php
/**
 * 功能 - 車輛限速設定
 */
namespace App\Http\Controllers\Car;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Car\SpeedService as Service;

class Speed extends Controller
{
    protected $oServices;
    private $id = '5645912c2081a9470b8b4568';

    public function __construct(Request $request, Service $Service)
    {
        parent::__construct($request);
        $this->oServices = $Service;
    }

    /**
     * 頁面：列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aInfo = $this->oServices->find($this->id);
        /* Layout */
        return view($this->layouts,[
            'aInfo' => $aInfo['info']
        ]);
    }

    /**
     * 操作：更新資料
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return response()->json($this->oServices->edit($request->all()));
    }

}
