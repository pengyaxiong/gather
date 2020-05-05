<?php
//API
use Spatie\Activitylog\Models\Activity;

function success_data($msg, $data = '')
{
    return array('status' => 1, 'msg' => $msg, 'datas' => $data);
}

function error_data($msg, $data = '')
{
    return array('status' => 0, 'msg' => $msg, 'datas' => $data);
}

//UV
function uv()
{
    return \App\Models\Tool\UV::count();
}

//访问量
function see_num($type)
{
    $data = Activity::where('log_name', $type)->distinct('ip')->count('ip');
    return $data;
}

function getMobileLogo($mobile)
{
    $phone_json = file_get_contents('http://sp0.baidu.com/8aQDcjqpAAV3otqbppnN2DJv/api.php?query={' . $mobile . '}&resource_id=6004&ie=utf8&oe=utf8&format=json');
    $phone_array = json_decode($phone_json, true);
    if (is_array($phone_array) && $phone_array['data']) {
        $type = $phone_array['data'][0]['type'];
    } else {
        $type = '';
    }
    switch ($type) {
        case '中国移动':
            return '/yd.png';
            break;
        case '中国联通':
            return '/lt.png';
            break;
        case '中国电信':
            return '/dx.png';
            break;
        default:
            return '/404.png';
    }

}

function getMobileLocation($mobile)
{
    $phone_json = file_get_contents('http://sp0.baidu.com/8aQDcjqpAAV3otqbppnN2DJv/api.php?query={' . $mobile . '}&resource_id=6004&ie=utf8&oe=utf8&format=json');
    $phone_array = json_decode($phone_json, true);

    if (is_array($phone_array) && $phone_array['data']) {
        $location = $phone_array['data'][0]['prov'] . $phone_array['data'][0]['city'];
    } else {
        $location = '未知错误';
    }

    return $location;
}

function getMobileInfo($mobile)
{

    if (!preg_match("/^1[345789]\d{9}$/", $mobile)) {
        $phone_info = array();
        $phone_info['logo'] = '/404.png';
        $phone_info['location'] = '手机号码错误';
        $phone_info['type'] = '手机号码错误';
        return ['status' => 0, 'msg' => '手机号码错误！', 'data' => $phone_info];
    } else {
        $phone_json = file_get_contents('http://sp0.baidu.com/8aQDcjqpAAV3otqbppnN2DJv/api.php?query={' . $mobile . '}&resource_id=6004&ie=utf8&oe=utf8&format=json');
        $phone_array = json_decode($phone_json, true);
        $phone_info = array();
        $phone_info['mobile'] = $mobile;
        $phone_info['type'] = $phone_array['data'][0]['type'];
        $phone_info['location'] = $phone_array['data'][0]['prov'] . $phone_array['data'][0]['city'];
        switch ($phone_array['data'][0]['type']) {
            case '中国移动':
                $phone_info['logo'] = '/yd.png';
                break;
            case '中国联通':
                $phone_info['logo'] = '/lt.png';
                break;
            case '中国电信':
                $phone_info['logo'] = '/dx.png';
                break;
            default:
                $phone_info['logo'] = '/404.png';
        }

        return ['status' => 1, 'msg' => '查询成功', 'data' => $phone_info];
    }
}

/**
 * @param $arr [要写入的数据]
 * @param $filename [文件路径]
 * @return bool|int [description]
 */
function writeArr($arr, $filename)
{

    return file_put_contents($filename, "<?php\r\nreturn " . var_export($arr, true) . ";");

}

//系统文件管理
function dir_info($path)
{
    $result = [];
    $handle = opendir($path);
    //判断是否是图片
    $types = '.gif|.jpeg|.png|.bmp|.ico|.jpg';//定义检查的图片类型
    while ($file = readdir($handle)) {
        $array = [];
        if (substr($file, 0, 1) == ".") {
            continue;
        }
        $array["name"] = $file;
        if ($file == 'storage') {
            $array["type"] = "目录文件";
            continue;
        } else {
            $array["type"] = get_file_type($file);
        }
        $array["size"] = get_file_size(filesize($path . "/" . $file));
        $array["date"] = date("Y 年 m 月 j 日", filemtime($file));
        $array["filemtime"] = strtotime(date("Y-m-d H:i:s", filemtime($file)));
        //获取文件扩展名
        $array['file_type'] = substr(strrchr($file, '.'), 1);
        $array['is_image'] = stripos($types, substr(strrchr($file, '.'), 1));
        $result[] = $array;
    }

    closedir($handle);
    return $result;
}

//声明一个函数用来返回文件的类型
function get_file_type($filename)
{
    $type = "";
    //通过filetype()函数返回的文件类型做为选择的条件
    switch (filetype($filename)) {
        case 'file':
            $type .= "普通文件";
            break;
        case 'dir':
            $type .= "目录文件";
            break;
        case 'block':
            $type .= "块设备文件";
            break;
        case 'char':
            $type .= "字符设备文件";
            break;
        case 'fifo':
            $type .= "命名管道文件";
            break;
        case 'link':
            $type .= "符号链接";
            break;
        case 'unknown':
            $type .= "末知类型";
            break;
        default:
            $type .= "没有检测到类型";
    }
    //返回转换后的类型
    return $type;
}

//自定义一个文件大小单位转换函数
function get_file_size($bytes)
{
    //如果提供的字节数大于等于2的40次方，则条件成立
    if ($bytes >= pow(2, 40)) {
        //将字节大小转换为同等的T大小
        $return = round($bytes / pow(1024, 4), 2);
        //单位为TB
        $suffix = "TB";
        //如果提供的字节数大于等于2的30次方，则条件成立
    } elseif ($bytes >= pow(2, 30)) {
        //将字节大小转换为同等的G大小
        $return = round($bytes / pow(1024, 3), 2);
        //单位为GB
        $suffix = "GB";
        //如果提供的字节数大于等于2的20次方，则条件成立
    } elseif ($bytes >= pow(2, 20)) {
        //将字节大小转换为同等的M大小
        $return = round($bytes / pow(1024, 2), 2);
        //单位为MB
        $suffix = "MB";
        //如果提供的字节数大于等于2的10次方，则条件成立
    } elseif ($bytes >= pow(2, 10)) {
        //将字节大小转换为同等的K大小
        $return = round($bytes / pow(1024, 1), 2);
        //单位为KB
        $suffix = "KB";
        //否则提供的字节数小于2的10次方，则条件成立
    } else {
        //字节大小单位不变
        $return = $bytes;
        //单位为Byte
        $suffix = "Byte";
    }
    //返回合适的文件大小和单位
    return $return . " " . $suffix;
}

//function tree(&$arr, $pid, $step)
//{
//    global $tree;
//    foreach($arr as $key=>$val) {
//        if($val['pid'] == $pid) {
//            $flg = str_repeat('└―',$step);
//            $val['name'] = $flg.$val['name'];
//            $tree[] = $val;
//            tree($arr , $val['cid'] ,$step+1);
//        }
//    }
//    return $tree;
//}


/**
 * 截取, 并加上...
 * @param $string
 * @param $size
 * @param bool $dot 是否加上..., 默认true
 * @return string
 */
function sub($string, $size = 24, $dot = true)
{
    $string = strip_tags(trim($string));
    if (strlen($string) > $size) {
        $string = mb_substr($string, 0, $size);
        $string .= $dot ? '**' : '';
        return $string;
    }

    return $string;
}

function hideStar($str)
{ //用户名、邮箱、手机账号中间字符串以*隐藏
    if (strpos($str, '@')) {
        $email_array = explode("@", $str);
        $prevfix = (strlen($email_array[0]) < 4) ? "" : substr($str, 0, 3); //邮箱前缀
        $count = 0;
        $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $str, -1, $count);
        $rs = $prevfix . $str;
    } else {
        $pattern = '/(1[3458]{1}[0-9])[0-9]{4}([0-9]{4})/i';
        if (preg_match($pattern, $str)) {
            $rs = preg_replace($pattern, '$1****$2', $str); // substr_replace($name,'****',3,4);
        } else {
            $rs = substr($str, 0, 3) . "***" . substr($str, -1);
        }
    }
    return $rs;
}


/*
 *  millisecond 毫秒
 * 返回时间戳的毫秒数部分
 */
function get_millisecond()
{
    list($usec, $sec) = explode(" ", microtime());
    $msec = round($usec * 1000);
    return $msec;
}

/**
 * 按符号截取字符串的指定部分
 * @param string $str 需要截取的字符串
 * @param string $sign 需要截取的符号
 * @param int $number 如是正数以0为起点从左向右截  负数则从右向左截
 * @return string 返回截取的内容
 */
function cut_str($str, $sign, $number)
{
    $array = explode($sign, $str);
    $length = count($array);
    if ($number < 0) {
        $new_array = array_reverse($array);
        $abs_number = abs($number);
        if ($abs_number > $length) {
            return 'error';
        } else {
            return $new_array[$abs_number - 1];
        }
    } else {
        if ($number >= $length) {
            return 'error';
        } else {
            return $array[$number];
        }
    }
}


/**
 * 递归生成无限极分类数组
 * @param $data
 * @param int $parent_id
 * @param int $count
 * @return array
 */
function tree(&$data, $parent_id = 0, $count = 1)
{
    static $treeList = [];

    foreach ($data as $key => $value) {
        if ($value['parent_id'] == $parent_id) {
            $value['count'] = $count;
            $treeList [] = $value;
            unset($data[$key]);
            tree($data, $value['id'], $count + 1);
        }
    }
    return $treeList;
}

/**
 * 栏目名前面加上缩进
 * @param $count
 * @return string
 */
function indent_category($count)
{
    $str = '';
    for ($i = 1; $i < $count; $i++) {
        $str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    }
    return $str;
}


function order_color($status)
{
    switch ($status) {
        case '1':
            return 'uc-order-item-pay';         //橙
            break;
        case '2':
            return 'uc-order-item-shipping';    //红
            break;
        case '3':
            return 'uc-order-item-shipping';    //红
            break;
        case '4':
            return 'uc-order-item-receiving';   //绿
            break;
        case '5':
            return 'uc-order-item-finish';      //灰
            break;
        default:
            return 'uc-order-item-finish';
    }
}


//是否...
function is_something($attr, $module)
{
    return $module->$attr ? '<span class="am-icon-check is_something" data-attr="' . $attr . '"></span>' : '<span class="am-icon-close is_something" data-attr="' . $attr . '"></span>';
}

//显示栏目对应文章
function show_articles($category)
{
    if ($category->type == 2) {
        return '<a class="am-badge am-badge-secondary" href="' . route('cms.article.index', ['category_id' => $category->id]) . '">查看栏目文章</a>';
    }
}

//显示分类对应商品
function show_category_products($category)
{
    if (!$category->products->isEmpty()) {
        return '<a class="am-badge am-badge-secondary" href="' . route('shop.product.index', ['category_id' => $category->id]) . '">查看商品</a>';
    }
}

function show_brand_products($brand)
{
    if (!$brand->products->isEmpty()) {
        return '<a class="am-badge am-badge-secondary" href="' . route('shop.product.index', ['brand_id' => $brand->id]) . '">查看商品</a>';
    }
}


function time_format($attr, $datetime)
{
    if ($datetime == "") {
        return "";
    }
    return date($attr, strtotime($datetime));
}


/**
 * 根据类型,返回url或者key
 * @param $value
 * @return array
 */
function wechat_key_url($value)
{
    $result = [];

    $result['type'] = $value['type'];
    $result['name'] = $value['name'];
    if ($value['type'] == "click") {
        $result['key'] = $value['value'];
    } else {
        $result['url'] = $value['value'];
    }
    return $result;
}

function category_indent($count)
{
    $str = '';
    for ($i = 0; $i < $count; $i++) {
        $str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    }
    return $str;
}


//生成image标签的其他属性
function build_image_attributes($attributes)
{
    $attributes_html = '';
    if ($attributes) {
        foreach ($attributes as $key => $value) {
            $attributes_html .= $key . '= "' . $value . '"';
        }
    }
    return $attributes_html;
}

/**
 * 原始图片
 * @param $model
 * @param string $class
 * @param string $alt
 * @return string
 */
function image_url($model, $attributes = [], $is_online = false)
{
    $attributes_html = build_image_attributes($attributes);
    if ($model->image) {
        if ($is_online) {
            return ' <img src="' . env('QINIU_IMAGES_LINK') . $model->image . '" ' . $attributes_html . '>';
        } else {
            return ' <img src="' . $model->image . '" ' . $attributes_html . '>';
        }
    } else {
        return ' <img src="/no_img.jpg" ' . $attributes_html . '>';
    }

}

/**
 * thumb缩略图
 * @param $model
 * @param string $class
 * @param string $alt
 * @return string
 */
function thumb_url($model, $attributes = [], $is_online = false)
{

    $attributes_html = build_image_attributes($attributes);
    if ($model->image) {
        if ($is_online) {
            return ' <img src="' . env('QINIU_IMAGES_LINK') . $model->image . '-thumb' . '" ' . $attributes_html . '>';
        } else {
            return ' <img src="' . $model->image . '" ' . $attributes_html . '>';
        }
    } else {
        return ' <img src="/no_img.jpg" ' . $attributes_html . '>';
    }

}

/**
 * large 缩略图
 * @param $model
 * @param string $class
 * @param string $alt
 * @return string
 */
function large_url($model, $attributes = [], $is_online = false)
{
    $attributes_html = build_image_attributes($attributes);
    if ($model->image) {
        if ($is_online) {
            return ' <img src="' . env('QINIU_IMAGES_LINK') . $model->image . '-large' . '" ' . $attributes_html . '>';
        } else {
            return ' <img src="' . $model->image . '" ' . $attributes_html . '>';
        }
    } else {
        return ' <img src="/no_img.jpg" ' . $attributes_html . '>';
    }


}