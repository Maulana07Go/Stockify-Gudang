<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ManagerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'Manajer Gudang') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
