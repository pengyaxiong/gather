<?php

namespace App\Http\Controllers\Admin\System;

use App\Models\System\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\System as Requests;

use App\Models\System\Role;

class PermissionController extends Controller
{
    /**
     * 权限列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index()
    {
        $permissions = Permission::get_permissions();
        return view('admin.system.permission.index', compact('permissions'));
    }

    /**
     * 保存
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function store(Request $request)
    {
        if ($request->parent_id != 0 && !\Route::has($request->name)) {
            return ['status' => 0, 'msg' => '路由名称不存在，请修改后再保存~'];
        }

        Permission::create($request->all());
        Permission::clear();
        return ['status' => 1, 'permissions' => Permission::get_permissions()];
    }

    /**
     * 编辑
     * @param $id
     * @return mixed
     */
    function edit($id)
    {
        return Permission::find($id);
    }

    function update(Request $request, $id)
    {
        if ($request->parent_id != 0 && !\Route::has($request->name)) {
            return ['status' => 0, 'msg' => '路由名称不存在，请修改后再保存~'];
        }

        $permission = Permission::find($id);
        $permission->update($request->all());
        Permission::clear();
        return ['status' => 1, 'permissions' => Permission::get_permissions()];
    }

    function destroy($id)
    {
        if (!Permission::check_children($id)) {
            return ['status' => 0, 'msg' => '当前菜单有子菜单，请先将子菜单删除后再尝试删除~'];
        }

        Permission::destroy($id);
        Permission::clear();
        return ['status' => 1, 'permissions' => Permission::get_permissions()];
    }

    /**
     * 排序
     * @param Request $request
     * @return array
     */
    function sort_order(Request $request)
    {
        $sort_order = json_decode($request->sort_order);

        //一级
        foreach ($sort_order as $key => $value) {
            Permission::sort_order($value->id, 0, $key);

            //二级
            if (isset($value->children)) {
                foreach ($value->children as $key_children => $children) {
                    Permission::sort_order($children->id, $value->id, $key_children);

                    //三级
                    if (isset($children->children)) {
                        foreach ($children->children as $key_c => $c) {
                            Permission::sort_order($c->id, $children->id, $key_c);
                        }
                    }
                }
            }
        }

        Permission::clear();
    }
}
