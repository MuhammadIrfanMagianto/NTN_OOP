<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Project lama tidak memangkas (trim) spasi pada password register.
        // Laravel secara default memangkas semua input kecuali field "password",
        // jadi field "reg-password" dikecualikan agar perilakunya sama persis.
        $middleware->trimStrings(except: ['reg-password']);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
