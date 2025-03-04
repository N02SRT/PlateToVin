<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // You can pass the API key in the Authorization header
        $providedKey = $request->header('Authorization');

        // Compare against the value in .env
        if ($providedKey !== env('APP_API_KEY')) {
            return response()->json(['message' => 'Unauthorized']);
        }

        return $next($request);
    }
}
