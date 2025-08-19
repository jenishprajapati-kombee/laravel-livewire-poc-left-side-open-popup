<?php

use App\Providers\AppServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )->withProviders([
       // \Bugsnag\BugsnagLaravel\BugsnagServiceProvider::class,
         ])
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectUsersTo(AppServiceProvider::HOME);
        $middleware->trustProxies(at: '*');

        $middleware->append([
            \App\Http\Middleware\HttpResponseHeaders::class,
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);

        $middleware->api([
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);

        $middleware->web([
            \App\Http\Middleware\HostVerificationMiddleware::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
             \Illuminate\Session\Middleware\AuthenticateSession::class,
        ]);

        $middleware->throttleApi('200,1');

        $middleware->alias([
            'adminAuth' => \App\Http\Middleware\AdminAuthenticate::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
