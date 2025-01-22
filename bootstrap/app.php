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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'Auth' => \App\Http\Middleware\Auth::class,
            'CheckAuthAdmin' => \App\Http\Middleware\CheckAuthAdmin::class,
            'CheckAuthCustomer' => \App\Http\Middleware\CheckAuthCustomer::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'stripe/*',
            '/handleCallbackPerfectMoney',
            '/handlePayeerCallback',
            '/blockchain/receiveTransactionBTC',
            '/blockchain/receiveTransactionLTC',
            '/blockchain/receiveTransactionBCH',
            '/blockchain/receiveTransactionETH',
            '/blockchain/receiveTransactionUSDT_BSC_BEP20',
            '/blockchain/websocket-error',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
