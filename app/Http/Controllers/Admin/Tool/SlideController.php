<?php

namespace App\Http\Controllers\Admin\Tool;

use App\Models\Tool\Slide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlideController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $where = function ($query) use ($request) {
            if ($request->has('keyword') and $request->keyword != '') {
                $search = "%" . $request->keyword . "%";
                $query->where('title', 'like', $search);
            }
            if ($request->has('is_show') and $request->is_show != '-1') {
                $query->where('is_show',  $request->is_show);
            }
        };
        $slides = Slide::where($where)->paginate(config('admin.page_size'));
        //分页处理
        $page = isset($page) ? $request['page'] : 1;
        $slides = $slides->appends(array(
            'title' => $request->keyword,
            'page' => $page
        ));
        return view('admin.tool.slide.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tool.slide.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $messages = [
            'image.required' => '图片不能为空!'
        ];
        $this->validate($request, [
            'image' => 'required',
        ],$messages);

        $slides = $request->all();
        Slide::create($slides);
        return redirect(route('tool.slide.index'))->with('notice', '新增成功~');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slide = Slide::find($id);
        return view('admin.tool.slide.edit', compact('slide'));
    }

    /**
     * @param Request $request
     * @param Slide $slide
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Slide $slide)
    {
        $messages = [
            'image.required' => '图片不能为空!'
        ];
        $this->validate($request, [
            'image' => 'required',
        ],$messages);
        $slide->update($request->all());
        return redirect(route('tool.slide.index'))->with('notice', '编辑成功~');
    }

    /**
     * @param Slide $slide
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Slide $slide)
    {
        $slide->delete();
        return back()->with('notice', '删数成功~');
    }

    /**
     * Ajax修改属性
     * @param Request $request
     * @return array
     */
    function is_something(Request $request)
    {
        $attr = $request->attr;
        $slide = Slide::find($request->id);
        $value = $slide->$attr ? false : true;
        $slide->$attr = $value;
        $slide->save();

    }

    /**
     * Ajax排序
     * @param Request $request
     * @return array
     */
    function sort_order(Request $request)
    {
        $slide = Slide::find($request->id);
        $slide->sort_order = $request->sort_order;
        $slide->save();
    }
}
