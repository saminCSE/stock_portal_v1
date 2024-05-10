<?php

namespace App\Http\Middleware;

use App\Models\PortalUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class PortalAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
    
        if(!Auth::check() && Cookie::get('sheba-auth-token')) {
            $token = Cookie::get('sheba-auth-token');
            $decrypt_token = Crypt::decrypt($token);
            $user = PortalUser::where('api_token',$decrypt_token)->first();
            if($user) {
                Auth::loginUsingId($user->id); 
                $domain = env('SESSION_DOMAIN', null);
                $crypt_token = Crypt::encrypt($user->api_token);
                Cookie::queue('sheba-auth-token', $crypt_token, 3780, '/', $domain);
            }
            else {
                Cookie::queue(Cookie::forget('sheba-auth-token'));
            }  
        }
        else if (Auth::check() && !Cookie::get('sheba-auth-token')) {
            Auth::logout();
            Cookie::queue(Cookie::forget('sheba-auth-token'));
        }
        return $next($request);
    }
}
