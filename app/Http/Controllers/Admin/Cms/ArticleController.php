<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Cms\Article;
use App\Models\Cms\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct()
    {
        view()->share([
            'categories' => Category::get_categories(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查找
        $where = function ($query) use ($request) {
            if ($request->has('keyword') and $request->keyword != '') {
                $search = "%" . $request->keyword . "%";
                $query->where('title', 'like', $search);
            }

            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }
        };

        $articles = Article::with('category')->where($where)
            ->orderBy('is_top', 'desc')->orderBy('created_at', 'desc')
            ->paginate(config('admin.page_size'));

        //分页处理
        $page = isset($page) ? $request['page'] : 1;
        $articles = $articles->appends(array(
            'title' => $request->keyword,
            'category_id' => $request->category_id,
            'page' => $page
        ));

        return view('admin.cms.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cms.article.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
        ]);
        $article = $request->all();
        Article::create($article);
        return back()->with('notice', '新增成功~');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request,$id)
    {
        $article = Article::find($id);
        $ip = $request->getClientIp();
        $activity = activity()->inLog('see_article')
            ->performedOn($article)
            ->withProperties(['ip' => $ip])
            ->causedBy(Auth::user())
            ->log('查看文章');
        $activity->ip = $ip;
        $activity->save();

        $article->see_num += 1;
        $article->save();

        return view('admin.cms.article.show', compact('article'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function edit($id)
    {
        $article = Article::find($id);
        return view('admin.cms.article.edit', compact('article'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
        ]);

        $article = Article::find($id);
        $article->update($request->all());
        return back()->with('notice', '编辑成功~');
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function destroy($id)
    {
        Article::destroy($id);
        return back()->with('notice', '被删文章已进入回收站~');
    }

    public function force_destroy($id)
    {
        Article::withTrashed()->where('id', $id)->forceDelete();
        return back()->with('notice', '删除成功');
    }

    /**
     * 多选删除
     * @param Request $request
     * @return array
     */
    function destroy_checked(Request $request)
    {
        $checked_id = $request->input("checked_id");
        Article::destroy($checked_id);

    }

    /**
     * 多选永久删除
     * @param Request $request
     * @return array
     */
    function force_destroy_checked(Request $request)
    {
        $checked_id = $request->input("checked_id");
        Article::withTrashed()->whereIn('id', $checked_id)->forceDelete();

    }

    /**
     * 还原
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        Article::withTrashed()->where('id', $id)->restore();
        return back()->with('notice', '还原成功');
    }

    /**
     * 多选还原
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore_checked(Request $request)
    {
        $checked_id = $request->input("checked_id");
        Article::withTrashed()->whereIn('id', $checked_id)->restore();
        return back()->with('notice', '还原成功');
    }

    /**
     * 回收站
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function trash()
    {
        $articles = Article::with('category')->onlyTrashed()->paginate(config('admin.page_size'));
        return view('admin.cms.article.trash', compact('articles'));
    }

    /**
     * Ajax修改属性
     * @param Request $request
     * @return array
     */
    function is_something(Request $request)
    {
        $attr = $request->attr;
        $article = Article::find($request->id);
        $value = $article->$attr ? false : true;
        $article->$attr = $value;
        $article->save();
    }
}
