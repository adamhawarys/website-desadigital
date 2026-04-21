<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;

class CatatVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $ip     = $request->ip();
        $hari   = now()->toDateString();

        // Catat hanya kalau belum ada hari ini dari IP yang sama
        Visitor::firstOrCreate([
            'ip_address' => $ip,
            'tanggal'    => $hari,
        ]);

        return $next($request);
    }
}