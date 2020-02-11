<?php

namespace App\Http\Controllers\Admin\System;

use App\Models\System\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\System as Requests;

use App\Models\System\Role;

class RoleController extends Controller
{
    /**
     * 用户组列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $where = function ($query) use ($request) {
            if ($request->has('keyword') and $request->keyword != '') {
                $search = "%" . $request->keyword . "%";
                $query->where('name', 'like', $search);
            }
        };

        $roles = Role::where($where)->paginate(config('admin.page_size'));
        return view('admin.system.role.index', compact('roles'));
    }

    /**
     * 新增
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $permissions = Permission::get_permissions();
        return view('admin.system.role.create', compact('permissions'));
    }

    /**
     * 保存
     * @param Requests\RoleStore $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Requests\RoleStore $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->permission_id);
        return redirect(route('system.role.index'))->with('notice', '新增成功~');
    }

    /**
     * 编辑用户组
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);
        $role_permissions = $role->permissions->pluck('id');
        $permissions = Permission::get_permissions();
        return view('admin.system.role.edit', compact('role', 'role_permissions', 'permissions'));
    }

    /**
     * 更新用户组
     * @param Requests\RoleUpdate $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Requests\RoleUpdate $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        $role->permissions()->sync($request->permission_id);
        return back()->with('notice', '修改成功~');
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Role::destroy($id);
        return redirect(route('system.role.index'))->with('notice', '删除成功~');
    }
}
