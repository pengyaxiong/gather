<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class UV
{
    public $return_array = [];// 返回带有MAC地址的字串数组
    public $mac_addr;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
//    public function handle($request, Closure $next)
//    {
//        return $next($request);
//    }
    public function handle($request, Closure $next, $guard = null)
    {

        if (config('admin.statistics') == true) { // 此处可以不定义配置开关。
            // 清空Redis数据库
           //  Redis::flushall();
            //查询所有WebStatistics缓存记录数据
            $count = Redis::LLEN('WebStatistics');
            $redisList = Redis::lrange('WebStatistics', 0, $count);

            if ($count > 0) {
                foreach ($redisList as $key => $value) {
                    $value=json_decode($value,true);
                    if ($value['ip'] == $this->getIp()) {
                        continue;
                    }
                    // 自主获取需要存储的数组。
                    $redisLine = [
                        'ip' => $this->getIp(),
                        'brow' => $this->browseInfo(),
                        'mac' => $this->GetMacAddr(config('admin.os_type')),
                        'created_at' => time(),
                    ];
                    Redis::lpush('WebStatistics', json_encode($redisLine, JSON_UNESCAPED_UNICODE));
                }


            } else {
                $redisLine = [
                    'ip' => $this->getIp(),
                    'brow' => $this->browseInfo(),
                    'mac' => $this->GetMacAddr(config('admin.os_type')),
                    'created_at' => time(),
                ];
                Redis::lpush('WebStatistics', json_encode($redisLine, JSON_UNESCAPED_UNICODE));
            }

            return $next($request);
        } else {

            return $next($request);
        }
    }

    /**
     * 访问者IP
     * @return string
     */
    private function getIp()
    {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        } else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (!empty($_SERVER["REMOTE_ADDR"])) {
            $cip = $_SERVER["REMOTE_ADDR"];
        } else {
            $cip = '';
        }
        preg_match("/[\d\.]{7,15}/", $cip, $cips);
        $cip = isset($cips[0]) ? $cips[0] : 'unknown';
        unset($cips);

        return $cip;
    }

    /**
     * 访问者浏览器
     * @return string
     */
    private function browseInfo()
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $br = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/MSIE/i', $br)) {
                $br = 'MSIE';
            } else if (preg_match('/Firefox/i', $br)) {
                $br = 'Firefox';
            } else if (preg_match('/Chrome/i', $br)) {
                $br = 'Chrome';
            } else if (preg_match('/Safari/i', $br)) {
                $br = 'Safari';
            } else if (preg_match('/Opera/i', $br)) {
                $br = 'Opera';
            } else {
                $br = 'Other';
            }
            return $br;
        } else {
            return 'unknow';
        }
    }

    /**
     * MAC地址
     * @param $os_type
     * @return mixed
     */
    private function GetMacAddr($os_type)
    {
        switch (strtolower($os_type)) {
            case "linux":
                self::forLinux();
                break;
            case "solaris":
                break;
            case "unix":
                break;
            case "aix":
                break;
            default:
                self::forWindows();
                break;
        }

        $temp_array = array();
        foreach ($this->return_array as $value) {

            if (
            preg_match("/[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f]/i", $value,
                $temp_array)) {
                $this->mac_addr = $temp_array[0];
                break;
            }

        }
        unset($temp_array);
        return $this->mac_addr;
    }


    function forWindows()
    {
        @exec("ipconfig /all", $this->return_array);
        if ($this->return_array)
            return $this->return_array;
        else {
            $ipconfig = $_SERVER["WINDIR"] . "\system32\ipconfig.exe";
            if (is_file($ipconfig))
                @exec($ipconfig . " /all", $this->return_array);
            else
                @exec($_SERVER["WINDIR"] . "\system\ipconfig.exe /all", $this->return_array);
            return $this->return_array;
        }
    }


    function forLinux()
    {
        @exec("ifconfig -a", $this->return_array);
        return $this->return_array;
    }
}
