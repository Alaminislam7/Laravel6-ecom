<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Adminlogin
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
        if(empty(Session::has('adminSession'))){
            return redirect('/admin-panel');
        }
        return $next($request);
    }
}
