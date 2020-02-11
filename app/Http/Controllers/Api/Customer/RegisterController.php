<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Cms\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\SMSService;

class RegisterController extends Controller
{
    protected $SMSService;

    public function __construct(SMSService $SMSService)
    {
        $this->send_sms = $SMSService;
    }

    public function change_password(Request $request)
    {
        $response = $this->send_sms->check($request);
        if ($response['status'] == 0) {
            return error_data($response['msg'], $response['datas']);
        }
        $customer = Customer::where(array('phone' => $request->phone))->first();
        $customer->password = bcrypt($request->password);
        $customer->save();
        return success_data('修改成功', $customer);
    }

    public function phone_login(Request $request)
    {
        $response = $this->send_sms->check($request);
        if ($response['status'] == 0) {
            return error_data($response['msg'], $response['datas']);
        }

        $ip = $request->getClientIp();
        $customer = Customer::where(array('phone' => $request->phone))->first();
        $activity = activity()->inLog('customer_login')
            ->performedOn($customer)
            ->withProperties(['ip' => $ip])
            ->causedBy($customer)
            ->log('登录成功');
        $activity->ip = $ip;
        $activity->save();

        return success_data('登陆成功', $customer);

    }

    public function register(Request $request)
    {
        $messages = [
            'phone.unique' => '不能重复注册!',
            'password.required' => '密码不能为空!',
            'password.min' => '密码最少为六位!',
            'password.confirmed' => '两次密码不一样!',
            'phone.required' => '手机号不能为空!',
        ];
        $rules = [
            'phone' => 'required|unique:customers,phone',
            'password' => 'required|min:6|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return error_data($error);
        }
        $response = $this->send_sms->check($request);
        if ($response['status'] == 0) {
            return error_data($response['msg'], $response['datas']);
        }
        $customer = Customer::create([
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'api_token' => str_random(64)
        ]);

        if ($customer) {
            return success_data('注册成功', $customer);

        } else {
            return error_data('注册失败');
        }
    }


    public function sms(Request $request)
    {
        $request_type = $request->request_type;  // 请求类型: "send_sms"->发送短信验证码；"check_verify_code"->短信验证码校验
        $send_phone = $request->phone;        // 待接收短信验证码的手机号码，一般由用户在登录或注册时输入

        $user_info = Customer::where(array('phone' => $send_phone))->exists();

        if ($user_info && $request_type == "send_sms") {

            return ['status' => 0, 'msg' => '该手机号已经注册过'];
        }

        if (!$user_info && $request_type == "check_verify_code") {

            return ['status' => 0, 'msg' => '该用户不存在'];
        }

        if (!preg_match("/^1[0-9]{10}$/", $send_phone)) {
            return error_data('手机号格式错误');
        }
        $response = $this->send_sms->code($send_phone, $request->ip());

        return $response;
    }

}
