<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'customer' => \App\Http\Middleware\CustomerAuth::class,
            'maintenance.mode' => \App\Http\Middleware\MaintenanceModeMiddleware::class,
            'admin.timeout' => \App\Http\Middleware\AdminSessionTimeout::class,
        ]);

        // Logged-in user hitting a guest-only route (the /login page)
        $middleware->redirectUsersTo(function (Request $request) {
            if ($request->is('login') || $request->is('admin') || $request->is('admin/*')) {
                return route('admin.dashboard');
            }

            return '/';
        });

        $middleware->web(append: [
            \App\Http\Middleware\NoCacheHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();