<?php

use Illuminate\Support\Facades\Route;

if (config('path-router.active')) {

    foreach (config('path-router.routes') as $routeKey => $routeConfig) {

        if (!($routeConfig['active'] ?? false) || !is_callable($routeConfig['handler'] ?? null)) {
            continue;
        }

        $routePrefix = $routeConfig['route_prefix'];
        $rootDir = $routeConfig['root_dir'];
        $middleware = $routeConfig['middleware'];
        $handler = $routeConfig['handler'];

        Route::any($routePrefix, function () use ($routeKey, $rootDir, $handler) {
            $viewPath = $rootDir . '/index';
            [$exist, $response] = $handler($viewPath, $routeKey);
            if ($exist) {
                return $response;
            }
            
            abort(404);
        })
            ->where('path', '(.*)')
            ->middleware($middleware)
            ->name($routeConfig['name'] ?? 'path-' .$routeKey);

        Route::any($routePrefix . '/{path}', function () use ($routeKey, $routePrefix, $rootDir, $handler) {
            $viewPath = str_replace($routePrefix . '/', $rootDir . '/', request()->path());
            [$exist, $response] = $handler($viewPath . '/index', $routeKey);
            if ($exist) {
                return $response;
            }
            [$exist, $response] = $handler($viewPath, $routeKey);
            if ($exist) {
                return $response;
            }
            abort(404);
        })
            ->where('path', '(.*)')
            ->middleware($middleware)
            ->name($routeConfig['name'] ?? 'path-' .$routeKey);
    }
}
