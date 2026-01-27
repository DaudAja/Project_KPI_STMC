<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next)
    {
        // Cek jika user login dan statusnya masih pending
        if (Auth::check() && Auth::user()->status === 'pending') {
            // Arahkan ke halaman informasi tunggu verifikasi
            return redirect()->route('waiting.verification');
        }

        return $next($request);
    }
}
