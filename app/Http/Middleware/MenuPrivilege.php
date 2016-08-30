<?php
/* 判斷功能權限 */
namespace App\Http\Middleware;

use Closure;
use Request;
use Config;
use Auth;
use App\Services\Admin\PrivilegeService as Service;

class MenuPrivilege
{
    protected $oService;

    /**
     * Create a new filter instance.
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Service $Service)
    {
        $this->oService = $Service;
    }

    /**
     * 檢查功能權限
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Config::get('website.privilege') == true) {
            $sPath = Request::path();
            $aPath = explode('/', $sPath);
            if (count($aPath) > 2) {
                $sPath = $aPath[0].'/'.$aPath[1];
            }
            /* 特例不作權限檢查 */
            if (!in_array($sPath, array('home', '/', 'Admin/User/Pwd'))) {
                /* 檢查該功能是否有使用權限 */
                if ($this->oService->checkPrivilege(Auth::user()->role_id, $sPath) != true) {
                    abort(403);
                }
            }
        }
        return $next($request);
    }
}
