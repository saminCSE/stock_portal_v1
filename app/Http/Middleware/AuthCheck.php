<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        // if(!session()->has('LoggedUser')){
        //     return redirect('login')->with('error','You must logged in.');
        // }
        if(is_null(Auth()->user())) {
            return redirect('login')->with('error','You must logged in.');
        }
        return $next($request);
    }
}
