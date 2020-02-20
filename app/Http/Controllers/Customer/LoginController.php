<?php

namespace App\Http\Controllers\Customer;

use App\Exceptions\AuthenticatesLogout;
use App\Models\System\Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, AuthenticatesLogout {
        AuthenticatesLogout::logout insteadof AuthenticatesUsers;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/customer';
    //protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest.customer', ['except' => 'logout']);
        //$this->middleware('guest.home')->except('logout');
        // $this->username = config('admin.global.username');
        $configs = Config::first();
        view()->share([
            'configs' => $configs,
        ]);
    }

    /**
     * 重写登录视图页面
     */
    public function showLoginForm()
    {
        return view('customer.login');
    }

    /**
     * 自定义认证驱动
     */
    protected function guard()
    {
        return auth()->guard('customer');
    }

    /** * 重写验证时使用的用户名字段 */
    public function username()
    {
        if (!is_null(request()->get('merged_at'))) {
            return request()->get('merged_at');
        }

        $login = request()->get('phone');

        if ($this->isPhoneNo($login)) {
            $field = 'phone';
        } else {
            $field = 'name';
        }
        request()->merge([$field => $login, 'merged_at' => $field]);


        return $field;
    }

    private function isPhoneNo($phone)
    {
        $g = "/^1[34578]\d{9}$/";

        return preg_match($g, $phone);
    }

    public function authenticated(Request $request, $user)
    {
        $ip = $request->getClientIp();
        $activity = activity()->inLog('customer_login')
             ->performedOn($user)
            ->withProperties(['ip' => $ip])
            ->causedBy($user)
            ->log('登录成功');
        $activity->ip = $ip;
        $activity->save();

    }
}
