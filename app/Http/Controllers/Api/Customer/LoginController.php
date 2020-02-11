<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $phone = $request->phone;
        $password = $request->password;
        $ip = $request->getClientIp();

        if (Auth::guard('customer')->attempt(['phone' => $phone, 'password' => $password])) {

            $customer = Auth::guard('customer')->user();

            $activity = activity()->inLog('customer_login')
                ->performedOn($customer)
                ->withProperties(['ip' => $ip])
                ->causedBy($customer)
                ->log('登录成功');
            $activity->ip = $ip;
            $activity->save();

            return success_data('登陆成功', $customer);

        } else {
            return error_data('账号密码错误');
        }
    }

}
