<?php

namespace App\Http\Middleware;

use App\Models\SeoRedirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeoRedirectMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        if ($path !== '/') {
            $path = '/' . $path;
        }

        $rule = SeoRedirect::where('source_url', $path)
            ->where('is_active', true)
            ->first();
        
        if ($rule) {
            if ($rule->type === 'CANONICAL') {
                $response = $next($request);
                if (method_exists($response, 'header')) {
                    $response->header('Link', '<' . $rule->destination_url . '>; rel="canonical"');
                }
                return $response;
            }
            return redirect($rule->destination_url, $rule->status_code);
        }

        return $next($request);
    }
}
