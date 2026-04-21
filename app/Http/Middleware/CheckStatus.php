<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->status == 'Active') {
            return $next($request);
        } elseif ($request->user()->status == 'Verify') {
            return redirect('/verify');
        }

       

        return redirect()->route('login_user')
            ->with('failed', 'Akun kamu tidak aktif. Hubungi admin.');
    }
}