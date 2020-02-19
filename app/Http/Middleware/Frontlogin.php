<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Frontlogin
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
        //echo Session::get('fronSession'); die;
        if(empty(Session::has('fronSession'))){
            return redirect('/login-register');
        }
        return $next($request);
    }
}
