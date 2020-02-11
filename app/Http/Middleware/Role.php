<?php

namespace App\Http\Middleware;

use Closure;
use Route, URL, Auth, Gate;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::user()->hasRole('超级管理员')) {
            return $next($request);
        }

        if (Route::currentRouteName() == 'admin') {
            return $next($request);
        }

        $previousUrl = URL::previous();
        if (Gate::denies(Route::currentRouteName())) {
            if ($request->ajax() && ($request->getMethod() != 'GET')) {
                return response()->json([
                    'status' => 0,
                    'code' => 403,
                    'msg' => '您没有权限执行此操作~'
                ]);
            } else {
                return response()->view('admin.errors.403', compact('previousUrl'));
            }
        }


        return $next($request);
    }
}
