<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // ...existing code...
    ];

    /**
     * The application's route middleware groups.
     * These middleware may be assigned to groups of routes.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // ...existing code...
        ],

        'api' => [
            // ...existing code...
        ],
    ];

    /**
     * The application's route middleware.
     * These middleware may be assigned to individual routes or route groups.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // ...existing code...
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        // ...existing code...
    ];
}
