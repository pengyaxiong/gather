<?php

namespace App\Http\Controllers\Admin\Tool;

use App\Models\Tool\Notice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
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
        };
        $notices = Notice::where($where)->paginate(config('admin.page_size'));
        //分页处理
        $page = isset($page) ? $request['page'] : 1;
        $notices = $notices->appends(array(
            'title' => $request->keyword,
            'page' => $page
        ));
        return view('admin.tool.notice.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tool.notice.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $messages = [
            'title.unique' => '标题不能重复!'
        ];
        if (!empty($request->title)){
            $this->validate($request, [
                'title' => 'unique:tool_notice,title',
            ],$messages);
        }

        $notices = $request->all();
        Notice::create($notices);
        return redirect(route('tool.notice.index'))->with('notice', '新增成功~');
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
        $notice = Notice::find($id);
        return view('admin.tool.notice.edit', compact('notice'));
    }

    /**
     * @param Request $request
     * @param Notice $notice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Notice $notice)
    {
        $messages = [
            'title.unique' => '标题不能重复!',
        ];
        if (!empty($request->title)){
            $this->validate($request, [
                'title' => 'unique:tool_notice,title,'.$notice->id,
            ],$messages);
        }
        $notice->update($request->all());
        return redirect(route('tool.notice.index'))->with('notice', '编辑成功~');
    }

    /**
     * @param Notice $notice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Notice $notice)
    {
        $notice->delete();
        return back()->with('notice', '删数成功~');
    }
}
