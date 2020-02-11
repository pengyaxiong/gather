<?php

namespace App\Http\Controllers\Api\Tool;

use App\Models\Tool\Spider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = function ($query) use ($request) {
            if ($request->has('keyword') and $request->keyword != '') {
                $search = "%" . $request->keyword . "%";
                $query->where('title', 'like', $search);
            }
        };
        $spiders = Spider::where($where)->paginate(config('admin.page_size'));
        //分页处理
        $page = isset($page) ? $request['page'] : 1;
        $spiders = $spiders->appends(array(
            'title' => $request->keyword,
            'page' => $page
        ));

        return success_data('成功', $spiders);
    }

    public function show($id)
    {
        $spider = Spider::find($id);

        return success_data('成功', $spider);
    }
}
