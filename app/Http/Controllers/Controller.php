<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Debugbar;
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /* layouts的前置詞 */
    protected $layouts = 'layouts.';

    public function __construct(Request $request)
    {
        /* 產生要layout的頁面路徑 */
        $aPath = explode('/', $request->path());
        if (count($aPath) > 2) {
            $this->layouts .= $aPath[0].'.'.$aPath[1].( in_array($aPath[2], array('Add', 'Edit')) ? 'Detail' : $aPath[2]);
        } else {
            $this->layouts .= str_replace('/', '.', $request->path());
        }
    }
}
