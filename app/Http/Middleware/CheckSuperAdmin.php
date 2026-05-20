<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
    // dd(auth()->user()->role);
        if(auth()->check() && auth()->user()->isSuperAdmin()){
            return $next($request);
        }
        return response()->json([
            "message" => "Unauthorized"
        ],403);
    }
}
