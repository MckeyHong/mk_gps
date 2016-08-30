<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator, Lang;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Record\RecordLoginService;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $username = 'username'; /* 登入帳號欄位名稱設定（預設為email） */
    protected $request;
    protected $oServices;
    private $maxLoginAttempts = 5; /* 最多可錯誤的次數 */
    private $lockoutTime = 30; /* 阻擋錯誤多次，隔N秒才能再次嘗次登入 */

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, RecordLoginService $Service)
    {
        $this->request = $request;
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->oServices = $Service;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6|max:15'
        ]);
    }

    /**
     * 登入介面覆寫（更改layout位置）
     * ref - vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php
     * @return  \Illuminate\Http\Response
     */
    public function getLogin()
    {
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }

        return view('layouts.login');
    }


    /**
     * 登入驗證覆寫
     * ref - vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {

        $this->validate($request, [
            $this->username => 'required', 'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            if ((int)Auth::user()->enable_type != 1) { /* 帳號停用中 */
                $this->addLoginInfo(3, $request->username);
                Auth::logout();
                return redirect('auth/login')
                    ->withInput($request->only($this->username, 'remember'))
                    ->withErrors([
                        $this->username => Lang::get('auth.disable'),
                    ]);
            } else {
                $this->addLoginInfo(1, $request->username);
                return $this->handleUserWasAuthenticated($request, $throttles);
            }
        }
        $this->addLoginInfo(2, $request->username);

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }


        return redirect($this->loginPath())
            ->withInput($request->only($this->username, 'remember'))
            ->withErrors([
                $this->username => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * 登出驗證覆寫
     * ref - vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        $this->addLoginInfo(4, (isset(Auth::user()->username) ? Auth::user()->username : ''));
        Auth::logout();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    /**
     * 寫入系統登入紀錄
     * @param   integer $iLoginType
     * @param   string  $sUsername
     * @return  array
     */
    private function addLoginInfo($iLoginType = 1, $sUsername = '')
    {
        return $this->oServices->addData([
            'login_username' => $sUsername,
            'login_type'     => (int)$iLoginType,
            'login_ip'       => $this->request->ip(),
            'create_date'    => time()
        ]);
    }
}
