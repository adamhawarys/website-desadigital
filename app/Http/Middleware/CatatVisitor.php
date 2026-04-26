<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;

class CatatVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $ip        = $request->ip();
        $userAgent = strtolower($request->userAgent() ?? '');

        // Keyword bot yang umum
        $botKeywords = [
            'bot', 'crawl', 'spider', 'slurp', 'baidu', 'bing',
            'google', 'yandex', 'facebook', 'wget', 'curl',
            'python', 'java', 'httpclient', 'scrapy', 'axios'
        ];

        $isBot = collect($botKeywords)->contains(fn($k) => str_contains($userAgent, $k));

        if (!$isBot) {
            Visitor::firstOrCreate([
                'ip_address' => $ip,
                'tanggal'    => now()->toDateString(),
            ]);
        }

        return $next($request);
    }
}