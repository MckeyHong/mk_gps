<?php
/**
 * 功能 - 工作班別設定 > 值勒人員資訊
 */
namespace App\Http\Controllers\Work;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Work\ShiftService as Service;

class Shift extends Controller
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
            'aGet'  => $aInfo['get'],
            'aYear' => $aInfo['year']
        ]);
    }

    public function getStaffShifts(Request $request)
    {
        return response()->json($this->oServices->getStaffShifts($request->all()));
    }

}
