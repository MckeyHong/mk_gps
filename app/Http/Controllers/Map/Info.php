<?php
/* 功能：地圖狀態顯示 */
namespace App\Http\Controllers\Map;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Map\InfoService as Service;
use App\Jobs\UpdateStation;

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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $aInfo = $this->oServices->getList($request->all());
        /* Layout */
        return view($this->layouts, [
            'aInfo'   => $aInfo['info'],
            'aGet'    => $aInfo['get'],
            'aCity'   => $aInfo['city'],
            'aStatus' => $aInfo['status'],
            'aArea'   => $aInfo['area']
        ]);
    }

    public function updateStation()
    {
        $this->dispatch(new UpdateStation());
    }


}
