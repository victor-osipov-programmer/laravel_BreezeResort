<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ErrorIfGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $request->headers->set('Accept', 'application/json');

        if (Auth::check()) {
            return $next($request);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
