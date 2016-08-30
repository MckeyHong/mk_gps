<?php
/* 功能 - 例行派工設定 */
namespace App\Http\Controllers\Work;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Work\AllocationService as Service;

class Allocation extends Controller
{
    protected $oServices;
    private $sListPath = '/Work/Allocation';

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
        return view($this->layouts, [
            'aInfo' => $aInfo['info'],
            'aGet'  => $aInfo['get']
        ]);
    }

    /**
     * 操作：更新資料
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return response()->json($this->oServices->edit(
            array_merge($request->all(), ['default_url' => $request->root().$this->sListPath])
        ));
    }

    /**
     * 操作：清除資料
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clear(Request $request)
    {
        return response()->json($this->oServices->clear($request->input('id')));
    }

    /**
     * 操作：刪除多筆資料
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clearMulti(Request $request)
    {
        return response()->json($this->oServices->clearMulti(
            array_merge($request->all(), ['default_url' => $request->root().$this->sListPath])
        ));
    }

    /**
     * 操作：下載匯入範例
     * @return \Illuminate\Http\Response
     */
    public function download()
    {
        return response()->download($this->oServices->download());
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
