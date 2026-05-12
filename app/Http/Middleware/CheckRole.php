<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
{
    // Cek apakah user sudah login dan apakah role-nya ada di dalam daftar yang diizinkan
    if (auth()->check() && in_array(auth()->user()->role, $roles)) {
        return $next($request);
    }

    // Kalau nggak punya akses, lempar ke dashboard atau login
    return redirect('/')->with('error', 'Lo nggak punya akses ke halaman ini, Boy!');
}
}
