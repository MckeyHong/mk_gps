<?php
/**
 * 功能 - 管理員資料
 */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\InfoService as Service;

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

    /**
     * 頁面：新增資料
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aTemp = $this->oServices->getInitial();
        /* Layout */
        return view($this->layouts, [
            'aInfo'  => $aTemp['info'],
            'aRole'  => $aTemp['role'],
            'aDept'  => $aTemp['dept']
        ]);
    }

    /**
     * 操作：新增資料
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json($this->oServices->add($request->all()));
    }

    /**
     * 頁面：編輯資料
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aTemp = $this->oServices->find($id);
        if ($aTemp['result'] != true) {
            abort(404);
        }

        /* Layout */
        return view($this->layouts, [
            'aInfo'  => $aTemp['info'],
            'aRole'  => $aTemp['role'],
            'aDept'  => $aTemp['dept']
        ]);
    }

    /**
     * 操作：更新資料
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response()->json($this->oServices->update($id, $request->all()));
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
        return response()->json($this->oServices->deleteMulti($request->all()));
    }

    /**
     * 操作：修改個人密碼
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePwd(Request $request)
    {
        return response()->json($this->oServices->changePwd($request->all()));
    }

}
