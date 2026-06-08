<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah sedang dalam mode impersonate
        if (session()->has('impersonate_as')) {
            $originalUserId = session('impersonate_original_user');
            $impersonatedUserId = session('impersonate_as');
            
            // Login sebagai karyawan
            if (!Auth::check() || Auth::id() != $impersonatedUserId) {
                Auth::loginUsingId($impersonatedUserId);
            }
        }
        
        return $next($request);
    }
}