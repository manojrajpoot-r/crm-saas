<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class TwoFactorMiddleware
{

     public function handle($request, Closure $next)
    {
       if (Auth::check() && Auth::user()->two_factor_enabled && !session()->has('2fa_verified') && !$request->is('2fa*')) {
            return redirect()->route('2fa.index');
       }

        return $next($request);
   }

}