<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';


    /**
     * 改为用户名登录
     * @return string
     */
    public function username()
    {
        return 'name';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {

        if ($user->state == 0) {

            $this->guard()->logout();

            $request->session()->invalidate();

            return back()->with('notice', '限制登陆');
        } else {
            $ip = $request->getClientIp();
            $activity = activity()->inLog('admin')
                // ->performedOn($customer)
                ->withProperties(['ip' => $ip])
                ->causedBy($user)
                ->log('登录成功');
            $activity->ip = $ip;
            $activity->save();
        }

    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/login');
    }
}
