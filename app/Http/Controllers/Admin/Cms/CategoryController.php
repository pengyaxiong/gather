<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Cms\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
        view()->share([
            'categories' => Category::get_categories(),
        ]);
    }

    /**
     * 栏目列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index()
    {
        return view('admin.cms.category.index');
    }

    /**
     * 新增
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.cms.category.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:article_categories|max:255',
        ]);
        $category = $request->all();
        Category::create($category);
        Category::clear();
        return redirect(route('cms.category.index'))->with('notice', '添加栏目成功');
    }

    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.cms.category.edit', compact('category'));
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
            'name' => 'required|max:255|unique:article_categories,name,'.$id,
        ]);

        $category = Category::find($id);
        $category->update($request->all());
        Category::clear();
        return redirect(route('cms.category.index'))->with('notice', '编辑成功~');
    }

    /**
     * Ajax修改属性
     * @param Request $request
     * @return array
     */
    function is_something(Request $request)
    {
        $attr = $request->attr;
        $category = Category::find($request->id);
        $value = $category->$attr ? false : true;
        $category->$attr = $value;
        $category->save();
        Category::clear();

    }

    /**
     * Ajax排序
     * @param Request $request
     * @return array
     */
    function sort_order(Request $request)
    {
        $category = Category::find($request->id);
        $category->sort_order = $request->sort_order;
        $category->save();
        Category::clear();
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function destroy($id)
    {
        if (!Category::check_children($id)) {
            return back()->with('alert', '当前栏目有子栏目，请先将子栏目删除后再尝试删除~');
        }

        if (!Category::check_articles($id)) {
            return back()->with('alert', '当前栏目有文章，请先将对应文章删除后再尝试删除~');
        }

        Category::destroy($id);
        Category::clear();
        return back()->with('notice', '删除成功');
    }
}
