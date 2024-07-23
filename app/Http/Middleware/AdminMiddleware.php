<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->status == '1'){
            return $next($request);
        }elseif(Auth::user()->status !== 1){
            return response()->json([
                'status' => 403,
                'message' => 'Forbidden: You do not have the necessary permissions.'
            ], 403);
        }
        return redirect('/');
    }
}
