<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    private $path;

    public function __construct(Request $request)
    {
        $this->path = isset($request->path) ? $request->path : getcwd();

    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|LengthAwarePaginator|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //多条件查找
//        $where = function ($query) use ($request) {
//            if ($request->has('name') and $request->name != '') {
//                $search = "%" . $request->name . "%";
//                $query->where('name', 'like', $search);
//            }
//
//            if ($request->has('file_type') and $request->file_type != -1) {
//                $search = "%" . $request->file_type . "%";
//                $query->where('file_type', 'like', $search);
//            }
//            if ($request->has('created_at') and $request->created_at != '') {
//                $time = explode(" ~ ", $request->input('created_at'));
//                foreach ($time as $k => $v) {
//                    $time["$k"] = $k == 0 ? $v . " 00:00:00" : $v . " 23:59:59";
//                }
//                $query->whereBetween('created_at', $time);
//            }
//        };

        $path = $this->path;

        //手动分页
        $file_list = dir_info($path);//打算输出的数组，二维
        foreach ($file_list as $k => $file) {
            if ($request->has('file_type') and $request->file_type != -1 and $request->file_type != $file['file_type']) {
                unset($file_list[$k]);
            }
            if ($request->has('name') and $request->name != '' and $request->name != $file['name']) {
                unset($file_list[$k]);
            }
            if ($request->has('created_at') and $request->created_at != '') {
                $time = explode(" ~ ", $request->input('created_at'));
                foreach ($time as $k => $v) {
                    $time["$k"] = $k == 0 ? $v . " 00:00:00" : $v . " 23:59:59";
                }

                if ($file['filemtime'] <= strtotime($time[0]) or $file['filemtime'] >= strtotime($time[1])) {
                    unset($file_list[$k]);
                }
            }
        }

        $file_type = array();
        foreach ($file_list as $file) {
            if (!$file['file_type']) {
                continue;
            }
            $file_type[] = $file['file_type'];
        }
        $file_type = array_unique($file_type);

        $perPage = config('admin.page_size');

        //分页处理
        $page = isset($request->page) ? $request->page : 1;

        //计算每页分页的初始位置
        $offset = ($page * $perPage) - $perPage;
        $item = array_slice($file_list, $offset, $perPage, true);
        // array_slice(array,start,length)   从start位置，去获取length参数。结果返回一条数据
        $total = count($file_list);

        $files = new LengthAwarePaginator($item, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            //就是设定个要分页的url地址。也可以手动通过 $paginator ->setPath(‘路径’) 设置
            'query' => $request->query(),
            'pageName' => 'page'
        ]);

        return view("admin.system.file", compact('files', 'path', 'file_type'));
    }

    /**
     * @param Request $request
     * @return bool|string
     */
    function get_contents($name)
    {
        $contents = file_get_contents($this->path . '/' . $name);
        return view("admin.system.file_edit", compact('contents','name'));
    }

    function upload_public(Request $request)
    {
        $extension = $request->file('file')->getClientOriginalExtension();
        $dir = Auth::user()->name . '_' . Auth::user()->id;

        Storage:: disk('my_file')->putFileAs($dir, $request->file('file'), time().'.'.$extension);
    }

    public function destroy_file($name)
    {
        $dir = Auth::user()->name . '_' . Auth::user()->id;
        if ($dir==$name){
            Storage::disk('my_file')->deleteDirectory($name);
        }else{
            Storage::disk('my_file')->delete($name);
        }
        return redirect(route('system.photo.index'))->with('notice', '删除成功~');
    }

    public function update_file(Request $request)
    {
        rename($this->path . '/' . $request->old_name, $this->path . '/' . $request->name);
        file_put_contents($this->path . '/' . $request->name, $request->contents);
        return redirect(route('system.photo.index'))->with('notice', '修改成功~');
    }

    /**
     * 文件上传类
     * @param Request $request
     * @return array
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('file') and $request->file('file')->isValid()) {

            //文件大小判断$filePath
            $max_size = 1024 * 1024 * 3;
            $size = $request->file('file')->getClientSize();
            if ($size > $max_size) {
                return ['status' => 0, 'msg' => '文件大小不能超过3M'];
            }
            $extension = $request->file('file')->getClientOriginalExtension();
            // $dir = Auth::user()->name . '_' . time();
            //original
            $path=$request->file->store('images','my_file');

            return ['status' => 1, 'image' => '/'.$path, 'image_url' => '/'.$path];

        }
    }

    /**
     * 文件上传类
     * @param Request $request
     * @return array
     */
    public function upload_img(Request $request)
    {
        if ($request->hasFile('file') and $request->file('file')->isValid()) {

            //数据验证
            $allow = array('image/jpeg', 'image/png', 'image/gif');

            $mine = $request->file('file')->getMimeType();
            if (!in_array($mine, $allow)) {
                return ['status' => 0, 'msg' => '文件类型错误，只能上传图片'];
            }

            //文件大小判断$filePath
            $max_size = 1024 * 1024 * 3;
            $size = $request->file('file')->getClientSize();
            if ($size > $max_size) {
                return ['status' => 0, 'msg' => '文件大小不能超过3M'];
            }

            //original图片
            $path = $request->file->store('images');

            //绝对路径
            $file_path = storage_path('app/') . $path;


            $url = '/storage/' . $path;
            //保存到七牛
            //qiniu_upload($file_path);

            //返回文件名
            // $image = basename($path);

            // return ['status' => 1, 'image' => $image, 'image_url' => env('QINIU_IMAGES_LINK') . $image];

            return ['status' => 1, 'image' => $url, 'image_url' => $url];
        }
    }

    /**
     * 上传网站ico图标
     * @param Request $request
     * @return array
     */
    public function upload_icon(Request $request)
    {
        if ($request->hasFile('file') and $request->file('file')->isValid()) {
            //取得之前文件的扩展名
            $extension = $request->file('file')->getClientOriginalExtension();
            if ($extension != 'ico') {
                return ['status' => 0, 'msg' => '文件类型错误，只能上传ico格式的图片'];
            }

            //文件大小判断
            $max_size = 1024 * 1024;
            $size = $request->file('file')->getClientSize();
            if ($size > $max_size) {
                return ['status' => 0, 'msg' => '文件大小不能超过1M'];
            }

            //上传文件夹，如果不存在，建立文件夹
            $path = getcwd();

            $file_name = "favicon.ico";
            $request->file('file')->move($path, $file_name);
        }
    }

    /**
     * 上传背景图
     * @param Request $request
     * @return array
     */
    public function upload_background_img(Request $request)
    {
        if ($request->hasFile('file') and $request->file('file')->isValid()) {

            $allow = array('image/jpeg', 'image/png', 'image/gif');

            $mine = $request->file('file')->getMimeType();
            if (!in_array($mine, $allow)) {
                return ['status' => 0, 'msg' => '文件类型错误，只能上传图片'];
            }

            //文件大小判断$filePath
            $max_size = 1024 * 1024 * 3;
            $size = $request->file('file')->getClientSize();
            if ($size > $max_size) {
                return ['status' => 0, 'msg' => '文件大小不能超过3M'];
            }

            //上传文件夹，如果不存在，建立文件夹
            $path = getcwd() . '/vendor/particles';

            $file_name = "timg.jpg";
            $request->file('file')->move($path, $file_name);

        }
    }
}
