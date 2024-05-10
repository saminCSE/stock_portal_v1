<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ApiAccess;

class BasicAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiAccess = ApiAccess::all();

        if ($apiAccess) {
            if ($apiAccess->status == '1') {
                $storedUsername = $apiAccess->username;
                $storedPassword = $apiAccess->password;
            } else {
                return response()->json(['error' => 'Access not active'], 403);
            }
        } else {
            return response()->json(['error' => 'Not Found'], 404);
        }
        // $storedUsername = env('BASIC_AUTH_USERNAME');
        // $storedPassword = env('BASIC_AUTH_PASSWORD');

        $providedCredentials = $request->getUser() . ':' . $request->getPassword();

        // Extract provided username and password
        $providedUsername = explode(':', $providedCredentials)[0];
        $providedPassword = explode(':', $providedCredentials)[1];

        if ($providedUsername !== $storedUsername || $providedPassword !== $storedPassword) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // If credentials match, proceed with the request
        return $next($request);
    }
}
