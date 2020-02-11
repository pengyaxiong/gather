<?php
/**
 * Created by PhpStorm.
 * User: PengYaxiong
 * Date: 2020/2/11
 * Time: 16:42
 */

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SMSService
{
    /**
     * 发送验证码
     *
     * @param string $mobile 手机号
     * @param string $ip IP地址
     * @return \Illuminate\Http\Response
     */
    public function code($mobile, $ip)
    {
        $this->checkThrottle($mobile, $ip);
        if (!preg_match("/^1[0-9]{10}$/", $mobile)) {
            return error_data('手机号格式错误');
        }
        $code = mt_rand(111111, 999999);
        $content = "【Leanzn】尊敬的客户，您的验证码为" . $code . "，请于2分钟内争取输入。如非本人操作，请忽略此短信。";//要发送的短信内容
        $result = $this->NewSms($mobile, $content);
        $result = explode('/', $result);
        if ($result[0] == '000') {
            $smsId = str_replace('sid:', '', $result[4]);
            Cache::put('sms.' . $smsId, compact('mobile', 'code'), 1800);
            self::throttle($mobile, $ip);
            return success_data('发送成功', compact('mobile', 'smsId'));
        } else {
            return error_data('网络错误');
        }
    }

    /**
     * 检查验证码
     *
     * @param Request $request
     */
    public function check(Request $request)
    {
        $smsId = $request->input('sms_id');
        $code = $request->input('code');
        $mobile = $request->input('phone');
        $key = 'sms.' . $smsId;

        if (!Cache::has($key)) {
            return error_data('验证码已失效');
        }

        $data = Cache::get($key);

        if ($mobile != $data['mobile'] || $code != $data['code']) {

            return error_data('验证码错误');# 验证码错误
        }

        return success_data('验证成功', $data);
    }

    /**
     * 存储发送频率
     *
     * @param string $mobile 手机号
     * @param string $ip IP地址
     */
    private function throttle($mobile, $ip)
    {
        Cache::put('sms.throttle.' . $mobile, 1, 30);
        Cache::put('sms.throttle.' . $ip, 1, 10);
    }

    /**
     * 检查发送频率
     *
     * @param string $mobile 手机号
     * @param string $ip IP地址
     */
    private function checkThrottle($mobile, $ip)
    {
        if (Cache::has('sms.throttle.' . $mobile)) {
            return error_data('不能重复发送验证码');
        }

        if (Cache::get('sms.throttle.' . $ip)) {
            return error_data('不能重复发送验证码');
        }
    }

    public function NewSms($mobile, $content)
    {
        $url = "http://service.winic.org:8009/sys_port/gateway/index.asp?";
        $data = "id=%s&pwd=%s&to=%s&Content=%s&time=";
        $id = urlencode(iconv("utf-8", "gb2312", "grubby"));
        $pwd = env('SMS_PWD');
        $to = $mobile;
        $content = urlencode(iconv("UTF-8", "GB2312", $content));
        $rdata = sprintf($data, $id, $pwd, $to, $content);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $rdata);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}