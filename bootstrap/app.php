<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsParent;
use App\Http\Middleware\EnsureUserIsSantri;
use App\Http\Middleware\EnsureUserIsUstadz;
use App\Http\Middleware\ProductionSecurityHeaders;
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
        $middleware->trustProxies('*');
        $middleware->append([ProductionSecurityHeaders::class]);
        $middleware->alias([
            'admin' => EnsureUserIsAdmin::class,
            'parent' => EnsureUserIsParent::class,
            'santri' => EnsureUserIsSantri::class,
            'ustadz' => EnsureUserIsUstadz::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
