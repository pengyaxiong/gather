<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    public function update(Request $request)
    {
        $type = $request->type;
        $customer = auth('api')->user();
        switch ($type) {
            case('bank_info'):
                $customer->update([
                    'card_name' => $request->card_name,
                    'card_id' => $request->card_id,
                    'bank_card' => $request->bank_card,
                    'bank_name' => $request->bank_name,
                    'bank_phone' => $request->bank_phone,
                ]);
                return success_data('提交成功');
                break;
//            case('credit_info'):
//                $customer->update([
//                    'credit_card' => $request->credit_card,
//                    'credit_name' => $request->credit_name,
//                    'credit_password' => $request->credit_password,
//                    'credit_phone' => $request->credit_phone,
//                ]);
//                return success_data('提交成功');
//                break;
//            case('base_info'):
//                $customer->update([
//                    'card_name' => $request->card_name,
//                    'card_id' => $request->card_id,
//                ]);
//                return success_data('提交成功');
//                break;
            case('chat_info'):
                $customer->update([
                    'alipay_num' => $request->alipay_num,
                    'weixin' => $request->weixin,
                    'qq' => $request->qq,
                    'email' => $request->email,
                ]);
                return success_data('提交成功');
                break;
            case('office_info'):
                $customer->update([
                    'office' => $request->office,
                    'city' => $request->city,
                    'address' => $request->address,
                    'office_phone' => $request->office_phone,
                    'office_type' => $request->office_type,
                    'office_money' => $request->office_money,
                ]);
                return success_data('提交成功');
                break;
            case('linkman_info'):
                $customer->update([
                    'linkman' => $request->linkman,
                    'linkman_relation' => $request->linkman_relation,
                    'linkman_phone' => $request->linkman_phone,
                ]);
                return success_data('提交成功');
                break;
            case('phone_info'):
                $customer->update([
                    'operator' => $request->operator,
                    'phone_password' => $request->phone_password,
                ]);
                return success_data('提交成功');
                break;
            case('order_info'):
                if ($customer->order_state == 1) {
                    $customer->update([
                        'order_state' => 2,
                        'money' => $request->money,
                    ]);
                }
                return success_data('提交成功');
                break;
            case('auditing_info'):
                $customer->update([
                    'sesame' => $request->sesame,
                    'credit_p' => $request->credit_p,
                    'taobao' => $request->taobao,
                    'jingdong' => $request->jingdong,
                    'accumulation' => $request->accumulation,
                    'social' => $request->social,
                ]);
                return success_data('提交成功');
                break;
            case('base_info'):
                $customer->update([
                    'phone' => $request->phone,
                    'card_name' => $request->card_name,
                    'card_id' => $request->card_id,
                    'sex' => $request->sex,
                    'bank_card' => $request->bank_card,
                    'bank_name' => $request->bank_name,
                    'aliplay_num' => $request->aliplay_num,
                    'credit_card' => $request->credit_card,
                ]);
                return success_data('提交成功');
                break;
            case('credit_info'):
                $customer->update([
                    'city' => $request->city,
                    'place_type' => $request->place_type,
                    'marriage' => $request->marriage,
                    'linkman' => $request->linkman,
                    'linkman_relation' => $request->linkman_relation,
                    'linkman_phone' => $request->linkman_phone,
                    'stability' => $request->stability,
                ]);
                return success_data('提交成功');
                break;
        }

    }
}
