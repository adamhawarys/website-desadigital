<?php

use App\Http\Middleware\CatatVisitor;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckStatus;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check_role' => CheckRole::class,
            'check_status' => CheckStatus::class,
            'prevent-back-history' => PreventBackHistory::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'sns/webhook',
        ]);

        $middleware->web(append: [
            CatatVisitor::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // kalau session habis / belum login, redirect ke login warga bukan 500
        $exceptions->render(function (AuthenticationException $e, $request) {
            return redirect()->route('login_user');
        });
    })->create();