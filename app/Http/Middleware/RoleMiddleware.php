<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Allowed roles for this route
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is logged in
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Please login first');
        }

        // Get user role from session
        $userRole = session('admin_role');

        // Check if user role is in allowed roles
        if (!in_array($userRole, $roles)) {
            // Redirect based on role
            if ($userRole === 'cashier') {
                return redirect()->route('admin.cashier')->with('error', 'Access denied. You do not have permission to access this page.');
            }
            
            return redirect()->route('admin.dashboard')->with('error', 'Access denied. You do not have permission to access this page.');
        }

        return $next($request);
    }
}
