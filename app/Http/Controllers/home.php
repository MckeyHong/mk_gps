<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RecordLogin;
use App\Services\Map\InfoService as Service;

class home extends Controller
{
    protected $oServices;

    public function __construct(Service $Service)
    {
        $this->oServices = $Service;
    }

    /**
     * 首頁
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $aInfo = $this->oServices->getList($request->all());
        /* Layout */
        return view('layouts.home',[
            'aInfo'   => $aInfo['info']
        ]);
    }

    public function todo()
    {
        /* Layout */
        return view('layouts.todo');
    }

}
