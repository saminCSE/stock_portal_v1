<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Permission
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
        return $next($request);
        $route = Route::getCurrentRoute()->getName();
      
        $userAction = array(
            'index'=>'list',
            'show'=>'list',
            'edit'=>'edit',
            'update'=>'edit',
            'destroy'=>'delete',
            'store'=>'create',
            'create'=>'create',
        );

        $title = '';
        $action = '';

        $route = Route::currentRouteName();
   
        if ($route) {
            $routeArray = explode('.', $route);
            list($title, $action) = $routeArray;
        }
        $searchStr = '';

        if($title){
            $searchStr .= $title;
            
        }

        if($action) {
            if (array_key_exists($action,$userAction))
                {
                    $searchStr .= ' '.$userAction[$action];
                }
            else
                {
                    
                    $searchStr = $route;
                }
           
        }
        else {
            $searchStr = $route;
        }


        if($request->ajax()){
            return $next($request);
        }
 
        else if(Auth()->user()){
          
            if(!Auth()->user()->can($searchStr)){
                abort(403,'Unauthorized Access');
            }
        }

        return $next($request);
    }
}
