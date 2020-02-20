<?php

namespace App\Http\Controllers\Customer;

use App\Models\Cms\Customer;
use App\Http\Controllers\Controller;
use App\Models\System\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/customer';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest.customer');
        $configs = Config::first();

        view()->share([
            'configs' => $configs,
        ]);
    }

    protected function index(Request $request)
    {
        return view('customer.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'code' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:customers',
            'password' => 'required|string|min:6|confirmed'

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\Cms\Customer
     */
    protected function create(array $data)
    {
        return Customer::create([
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
            'api_token' => str_random(64),
        ]);
    }

    /**
     * 自定义认证驱动
     */
    protected function guard()
    {
        return auth()->guard('customer');
    }

}
