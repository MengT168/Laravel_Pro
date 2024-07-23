<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized: Please log in first.'
            ], 401);
        }

        if (Auth::user()->status !== 1) { // Assuming status 1 is for admin
            return response()->json([
                'status' => 403,
                'message' => 'Forbidden: You do not have the necessary permissions.'
            ], 403);
        }

        return $next($request);
    }
}
