<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Security\SecurityAutomationService;

class AdminAuditLogger
{
    protected $security;

    public function __construct(SecurityAutomationService $security)
    {
        $this->security = $security;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('DELETE') || $request->isMethod('PATCH')) {
            $this->security->auditLog('Admin Action: ' . $request->route()->getName(), [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'params' => $request->except(['password', 'password_confirmation', '_token']),
            ]);
        }

        return $next($request);
    }
}
