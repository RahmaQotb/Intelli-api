<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Access denied: User not authenticated.');
        }

        $admin = Admin::where('email', $user->email)->first();

        if (!$admin || !$admin->is_super_admin) {
            abort(403, 'Access denied: You are not a super admin.');
        }

        return $next($request);    }
}
