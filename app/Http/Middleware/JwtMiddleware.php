<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
             echo($token);
             $jwtSecret = env('JWT_SECRET');
             dd($jwtSecret);
            //  $decoded = JWT::decode('DQLvRfOdmOBI7KJ84piW0lgQyTmT8rw4zjhFhS5zOat3B7yOfsHAujH9qg8I1oJw', $jwtSecret, ['HS256']);
            //  return $next($request);

        //  if ($token !== 'DQLvRfOdmOBI7KJ84piW0lgQyTmT8rw4zjhFhS5zOat3B7yOfsHAujH9qg8I1oJw') {
        //      return response()->json(['error' => 'Unauthorized'], 401);
        //  }
        //  return $next($request);
         
        } catch (Exception $e) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
    }
}
