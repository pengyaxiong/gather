<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Cms\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Activitylog\Models\Activity;

class CustomerController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $where = function ($query) use ($request) {
            if ($request->has('phone') and $request->phone != '') {
                $search = "%" . $request->phone . "%";
                $query->where('phone', 'like', $search);
            }

            if ($request->has('created_at') and $request->created_at != '') {
                $time = explode(" ~ ", $request->input('created_at'));
                $start = $time[0] . ' 00:00:00';
                $end = $time[1] . ' 23:59:59';
                $query->whereBetween('created_at', [$start, $end]);
            }
        };


        $customers = Customer::where($where)->paginate(config('admin.page_size'));

        //分页处理
        $page = isset($page) ? $request['page'] : 1;
        $customers = $customers->appends(array(
            'phone' => $request->phone,
            'created_at' => $request->created_at,
            'page' => $page
        ));

        return view('admin.cms.customer.index', compact('customers'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);

        return view('admin.cms.customer.edit', compact('customer'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $customer=Customer::find($id);

        $messages = [
            'password.min' => '密码最少为6位!'
        ];
        if (!empty($request->password)){
            $this->validate($request, [
                'password' => 'min:6'
            ],$messages);
        }

        if ($request->has('password') && $request->password != '') {
            if (!\Hash::check($request->old_password, $customer->password)) {
                return back()->with('alert', '原始密码错误~');
            }
            $customer->password = bcrypt($request->password);
        }

        $customer->name = $request->name;
        $customer->sex = $request->sex;
        $customer->age = $request->age;
        $customer->city = $request->city;
        $customer->address = $request->address;
        $customer->money = $request->money;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->qq = $request->qq;
        $customer->state = $request->state;
        $customer->save();

        return redirect(route('cms.customer.index'))->with('notice', '修改成功~');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::destroy($id);

        return redirect(route('cms.customer.index'))->with('notice', '删除成功~');
    }

    /**
     * Ajax修改属性
     * @param Request $request
     * @return array
     */
    function is_something(Request $request)
    {
        $attr = $request->attr;
        $customer = Customer::find($request->id);
        $value = $customer->$attr ? false : true;
        $customer->$attr = $value;
        $customer->save();
    }

}
