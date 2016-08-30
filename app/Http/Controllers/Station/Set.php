<?php
/* 功能 - 場站調度設定 */
namespace App\Http\Controllers\Station;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Station\SetService as Service;

class Set extends Controller
{
    protected $oServices;
    private $sListPath = '/Station/Set';

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
            'aGet'  => $aInfo['get'],
            'aCity' => $aInfo['city'],
            'aDay'  => $aInfo['day'],
        ]);
    }

    /**
     * 操作：資料匯出
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request)
    {
        return response()->download($this->oServices->download($request->all()));
    }

    /**
     * 操作：更新資料
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return response()->json($this->oServices->edit(
            array_merge($request->all(), ['default_url' => $request->root().$this->sListPath])
        ));
    }

    /**
     * 操作：匯入資料
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        return response()->json($this->oServices->import(
            array_merge($request->all(), ['default_url' => $request->root().$this->sListPath])
        ));
    }
}
