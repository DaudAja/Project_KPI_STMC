<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next)
{
    if (Auth::check()) {
        $status = Auth::user()->status;

        // 1. Jika status INACTIVE, arahkan ke halaman blokir
        if ($status === 'inactive') {
            // Cek agar tidak terjadi loop redirect
            if (!$request->is('account-inactive')) {
                return redirect()->route('account.inactive');
            }
        }

        // 2. Jika status PENDING, arahkan ke halaman verifikasi
        if ($status === 'pending') {
            if (!$request->is('waiting-verification')) {
                return redirect()->route('waiting.verification');
            }
        }
    }

    return $next($request);
}
}
