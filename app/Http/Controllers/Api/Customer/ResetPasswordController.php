<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth:api');
    }

    public function reset(Request $request)
    {
        $customer = auth('api')->user();

        $messages = [
            'password.min' => '密码最少为6位!'
        ];
        $rules = [
            'password' => 'confirmed|max:255|min:6'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return error_data($error);
        }

        if ($request->has('password') && $request->password != '') {
            if (!\Hash::check($request->old_password, $customer->password)) {
                return error_data('原始密码错误~');
            }
            $customer->password = bcrypt($request->password);
        }
        $customer->save();

        return success_data('修改成功', $customer);

    }
}
