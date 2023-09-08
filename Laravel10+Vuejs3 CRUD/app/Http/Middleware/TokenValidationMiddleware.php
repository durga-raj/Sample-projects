<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TokenValidationMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        if ($token) {
            if ($this->isValidToken($token)) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    private function isValidToken($token)
    {
        // Implement your logic to check the validity of the token against the personal access token table
        // Return true if the token is valid, false otherwise
    }
}
