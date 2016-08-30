<?php
/* 功能 - 工作狀態設定 */
namespace App\Http\Controllers\Work;

use Illuminate\Http\Request;
use App\Http\Requests\Work\StatusRequest;
use App\Http\Controllers\Controller;
use App\Services\Work\StatusService as Service;

class Status extends Controller
{
    protected $oServices;
    private $sListPath = '/Work/Status';

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
    public function index(StatusRequest $request)
    {
        $aInfo = $this->oServices->getList($request->all());
        /* Layout */
        return view($this->layouts,[
            'aInfo' => $aInfo['info'],
            'aGet'  => $aInfo['get']
        ]);
    }

    /**
     * 操作：新增資料
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json($this->oServices->add(
            array_merge($request->all(), ['default_url' => $request->root().$this->sListPath])
        ));
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

    /**
     * 操作：刪除資料
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json($this->oServices->delete($id));
    }

    /**
     * 操作：刪除多筆資料
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyMulti(Request $request)
    {
        return response()->json($this->oServices->deleteMulti(
            array_merge($request->all(), ['default_url' => $request->root().$this->sListPath])
        ));
    }

}
