<?php

namespace App\Http\Controllers\Admin;

use App\Models\System\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth, DB;
use App\Http\Requests\Admin\System as Requests;

class HomeController extends Controller
{
    /**
     * 系统后台首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::with('roles')->find($id);
        $user_roles = $user->roles->pluck('name');
        return view('admin.index', compact('user', 'user_roles'));
    }

    public function update(Requests\ChildUpdate $request, $id)
    {
        $user = User::find($id);
        $user->password = bcrypt($request->password);

        $user->name = $request->name;
        $user->phone = $request->phone;

        $user->save();

        return back()->with('notice', '编辑信息成功~');
    }

    public function link()
    {
        $host = 'http://suo.im';
        $path = '/api.php';
        $data = "?format=json&url=".urlencode(route('customer.register',['user_id'=>auth()->id()])).'&key=5cdbccf78e676d624f77a0cd@1fa1ba52d936a626405b288b3a81d32c';

        $url = $host . $path . $data;
        // var_dump($url);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        //读取响应
        return json_decode($res, true);
    }

}
