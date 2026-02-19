<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only track GET requests and ignore internal/admin calls if needed
        if ($request->isMethod('GET') && !$request->ajax()) {
            VisitorLog::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'referrer' => $request->header('referer'),
            ]);
        }

        return $next($request);
    }
}
