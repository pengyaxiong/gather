<?php

namespace App\Http\Controllers\Admin\Tool;

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
        return view('admin.tool.spider.index', compact('spiders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tool.spider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'title.unique' => '广告名称不能重复!',
            'image.required' => '图片不能为空!'
        ];
        if (!empty($request->title)){
            $this->validate($request, [
                'title' => 'unique:spiders,title',
                'image' => 'required'
            ],$messages);
        }

        $spiders = $request->all();
        Spider::create($spiders);
        return redirect(route('tool.spider.index'))->with('notice', '新增成功~');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $spider = Spider::find($id);
        return view('admin.tool.spider.edit', compact('spider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Spider $spider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Spider $spider)
    {
        $messages = [
            'title.unique' => '广告名称不能重复!',
            'image.required' => '图片不能为空!'
        ];
        if (!empty($request->title)){
            $this->validate($request, [
                'title' => 'unique:spiders,title,'.$spider->id,
                'image' => 'required'
            ],$messages);
        }
        $spider->update($request->all());
        return redirect(route('tool.spider.index'))->with('notice', '编辑成功~');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Spider $spider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Spider $spider)
    {
        $spider->delete();
        return back()->with('notice', '被删数据已进入回收站~');
    }

    /**
     * 永久删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function force_destroy($id)
    {
        Spider::withTrashed()->where('id', $id)->forceDelete();
        return back()->with('notice', '删除成功');
    }

    /**
     * 多选删除到回收站
     * @param Request $request
     * @return array
     */
    function destroy_checked(Request $request)
    {
        $checked_id = $request->input("checked_id");
        Spider::destroy($checked_id);
    }

    /**
     * 多选永久删除
     * @param Request $request
     * @return array
     */
    function force_destroy_checked(Request $request)
    {
        $checked_id = $request->input("checked_id");
        Spider::withTrashed()->whereIn('id', $checked_id)->forceDelete();
    }

    /**
     * 还原
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        Spider::withTrashed()->where('id', $id)->restore();
        return back()->with('notice', '还原成功');
    }

    /**
     * 多选还原
     * @param Request $request
     * @return array
     */
    public function restore_checked(Request $request)
    {
        $checked_id = $request->input("checked_id");
        Spider::withTrashed()->whereIn('id', $checked_id)->restore();
    }

    /**
     * 回收站
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function trash(Request $request)
    {
        $spiders = Spider::select()->onlyTrashed()->paginate(config('admin.page_size'));
        //分页处理
        $page = isset($page) ? $request['page'] : 1;
        $spiders = $spiders->appends(array(
            'title' => $request->keyword,
            'page' => $page
        ));
        return view('admin.tool.spider.trash', compact('spiders'));
    }

    /**
     * Ajax修改属性
     * @param Request $request
     * @return array
     */
    function is_something(Request $request)
    {
        $attr = $request->attr;
        $spider = Spider::find($request->id);
        $value = $spider->$attr ? false : true;
        if ($request->id == 1) {
            $value = true;
        }
        $spider->$attr = $value;
        $spider->save();
    }
}
