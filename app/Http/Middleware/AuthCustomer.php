<?php

namespace App\Http\Middleware;

use Closure;

class AuthCustomer
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

        if (auth()->guard('customer')->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('customer/login');
            }
        }
        return $next($request);
    }

}
