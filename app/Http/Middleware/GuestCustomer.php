<?php

namespace App\Http\Middleware;

use Closure;
class GuestCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->guard('customer')->check()) {
            return redirect('/customer');
        }
        return $next($request);
    }
}
