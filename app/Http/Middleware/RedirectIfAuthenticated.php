<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Route, URL;
class RedirectIfAuthenticated
{
    protected $except = [
        //排除
        'password.reset',
        'password.email',
        'password.update',
        'password.request',
        'register'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('/');
        }

        $previousUrl = URL::previous();
        $rout_name = Route::currentRouteName();
        if (in_array($rout_name, $this->except)) {
            return response()->view('admin.errors.404', compact('previousUrl'));
        }


        return $next($request);
    }
}
