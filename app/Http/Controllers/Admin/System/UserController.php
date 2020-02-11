<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\System as Requests;

use App\Models\System\User;
use App\Models\System\Role;

class UserController extends Controller
{
    /**
     * 用户列表
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

        $users = User::where($where)->paginate(config('admin.page_size'));

        //分页处理
        $page = isset($page) ? $request['page'] : 1;
        $users = $users->appends(array(
            'name' => $request->keyword,
            'page' => $page
        ));


        return view('admin.system.user.index', compact('users'));
    }

    /**
     * 新增
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.system.user.create', compact('roles'));
    }

    /**
     * 保存
     * @param Requests\UserStore $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Requests\UserStore $request)
    {
        $user = User::create([
            'name' => $request->name,
            'real_name' => $request->real_name,
            'state' => $request->state,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);
        $user->roles()->sync($request->role_id);
        return redirect(route('system.user.index'))->with('notice', '新增成功~');
    }

    /**
     * 编辑用户信息
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::with('roles')->find($id);
        $user_roles = $user->roles->pluck('id');
        $roles = Role::all();
        return view('admin.system.user.edit', compact('user', 'user_roles', 'roles'));
    }

    /**
     * 更新用户信息
     * @param Requests\UserUpdate $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Requests\UserUpdate $request, $id)
    {
        $user = User::find($id);

        $messages = [
            'password.min' => '密码最少为6位!'
        ];
        if (!empty($request->password)){
            $this->validate($request, [
                'password' => 'min:6'
            ],$messages);
        }


        if ($request->has('password') && $request->password != '') {
            if (!\Hash::check($request->old_password, $user->password)) {
                return back()->with('alert', '原始密码错误~');
            }
            $user->password = bcrypt($request->password);
        }

        $user->name = $request->name;
        $user->rate = $request->rate;
        $user->real_name = $request->real_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->qq = $request->qq;
        $user->state = $request->state;
        $user->save();

        //更新用户组信息
        $user->roles()->sync($request->role_id);
        return redirect(route('system.user.index'))->with('notice', '修改成功~');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect(route('system.user.index'))->with('notice', '删除成功~');
    }

    /**
     * Ajax修改属性
     * @param Request $request
     * @return array
     */
    function is_something(Request $request)
    {
        $attr = $request->attr;
        $user = User::find($request->id);
        $value = $user->$attr ? false : true;
        if ($request->id == 1) {
            $value = true;
        }
        $user->$attr = $value;
        $user->save();
    }
}
