<?php

use App\Http\Middleware\HttpsProtocol;
use App\Http\Middleware\SingleUserAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(['single.user.auth' => SingleUserAuth::class]);
        $middleware->append(HttpsProtocol::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
