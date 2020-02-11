<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use Cache, Auth, Hash;

class CacheController extends Controller
{
    /**
     * 清除缓存
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index()
    {
        return view('admin.system.cache.index');
    }

    /**
     * 执行清除缓存
     * @return \Illuminate\Http\RedirectResponse
     */
    function destroy()
    {
        Cache::flush();
        return back()->with('notice', '缓存清除成功~');
    }
}
