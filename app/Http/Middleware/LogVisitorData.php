<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Hit;

class LogVisitorData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Hit::create([
            "ip" => $request->ip(),
            "authorized" => $request->user() ? true : false,
            "os" => $request->userAgent(),
            "path" => $request->fullUrl(),
            "screenx" => 0,
        ]);
        return $next($request);
    }
}
