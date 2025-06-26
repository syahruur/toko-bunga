<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectPropperRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $isAdminRoute = $request->is('admin/*');
        // You can add more role-based route checks here if needed

        if (!$user) {
            return redirect()->route('login');
        }

        if ($isAdminRoute && !$user->isAdmin()) {
            // If user is not admin but tries to access admin, redirect to dashboard sesuai role
            if ($user->isCustomer()) {
                return redirect()->route('dashboard')->with('error', 'Akses ditolak. Anda dialihkan ke dashboard customer.');
            }
            return redirect()->route('home')->with('error', 'Akses ditolak.');
        }

        // If admin tries to access non-admin route, you can add logic here if needed

        return $next($request);
    }
}
