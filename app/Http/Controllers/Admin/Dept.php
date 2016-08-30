<?php

/**
 * 功能 - 組織部門
 */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\DeptService as Service;

class Dept extends Controller
{
    protected $oServices;

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
        $aInfo = $this->oServices->getList();

        /* Layout */
        return view($this->layouts, ['aInfo' => $aInfo['info']]);
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
     * 操作：更新資料
     * @param  \Illuminate\Http\Request  $request
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
    public function destroy(Request $request, $id)
    {
        return response()->json($this->oServices->delete($id, $request->all()));
    }

}