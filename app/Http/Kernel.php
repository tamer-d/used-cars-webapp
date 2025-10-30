<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // ... autres middlewares
        \App\Http\Middleware\HandleTimeoutException::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            // ... autres middlewares web
            \App\Http\Middleware\HandleTimeoutException::class,
        ],
    ];
}