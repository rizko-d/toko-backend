<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // ... existing code

    protected $routeMiddleware = [
        // ... existing middleware
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}
