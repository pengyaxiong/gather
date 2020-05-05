<?php

namespace App\Http\Controllers\Admin\Tool;

use App\Models\Tool\Help;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelpController extends Controller
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
        $helps = Help::where($where)->paginate(config('admin.page_size'));
        //分页处理
        $page = isset($page) ? $request['page'] : 1;
        $helps = $helps->appends(array(
            'title' => $request->keyword,
            'page' => $page
        ));
        return view('admin.tool.help.index', compact('helps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tool.help.create');
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
                'title' => 'unique:tool_help,title',
            ],$messages);
        }

        $helps = $request->all();
        Help::create($helps);
        return redirect(route('tool.help.index'))->with('notice', '新增成功~');
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
        $help = Help::find($id);
        return view('admin.tool.help.edit', compact('help'));
    }

    /**
     * @param Request $request
     * @param Help $help
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Help $help)
    {
        $messages = [
            'title.unique' => '标题不能重复!',
        ];
        if (!empty($request->title)){
            $this->validate($request, [
                'title' => 'unique:tool_help,title,'.$help->id,
            ],$messages);
        }
        $help->update($request->all());
        return redirect(route('tool.help.index'))->with('notice', '编辑成功~');
    }

    /**
     * @param Help $help
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Help $help)
    {
        $help->delete();
        return back()->with('notice', '删数成功~');
    }
}
