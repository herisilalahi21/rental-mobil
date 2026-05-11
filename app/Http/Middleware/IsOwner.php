<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsOwner
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah sudah login dan apakah role-nya owner
        if (Auth::check() && Auth::user()->role === 'owner') {
            return $next($request);
        }

        // Kalau bukan owner, lempar balik ke home
        return redirect('/')->with('error', 'Akses khusus Owner!');
    }
}
