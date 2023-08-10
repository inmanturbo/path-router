<?php

use Illuminate\Support\Facades\Route;

if (config('path-router.active')) {

    foreach (config('path-router.routes') as $routeKey => $routeValue) {

        if (! config('path-router.routes.'.$routeKey.'.active')) {
            continue;
        }
        if (! config('path-router.routes.'.$routeKey.'.handler') ||
            ! is_callable(config('path-router.routes.'.$routeKey.'.handler'))
        ) {
            continue;
        }

        Route::any(config('path-router.routes.'.$routeKey.'.route_prefix'), function () use ($routeKey) {
            $viewPath = config('path-router.routes.'.$routeKey.'.root_dir').'/index';
            [$exist, $response] = config('path-router.routes.'.$routeKey.'.handler')($viewPath, $routeKey);
            if ($exist) {
                return $response;
            }
            abort(404);
        })
            ->where('path', '(.*)')
            ->middleware(config('path-router.routes.'.$routeKey.'.middleware'))
            ->name('path');

        Route::any(config('path-router.routes.'.$routeKey.'.route_prefix').'/{path}', function () use ($routeKey) {
            $viewPath = str_replace(config('path-router.routes.'.$routeKey.'.route_prefix').'/', config('path-router.routes.'.$routeKey.'.root_dir').'/', request()->path());
            [$exist, $response] = config('path-router.routes.'.$routeKey.'.handler')($viewPath, $routeKey);
            if ($exist) {
                return $response;
            }
            [$exist, $response] = config('path-router.routes.'.$routeKey.'.handler')($viewPath.'/index', $routeKey);
            if ($exist) {
                return $response;
            }
            abort(404);
        })
            ->where('path', '(.*)')
            ->middleware(config('path-router.routes.'.$routeKey.'.middleware'))
            ->name('path-'.(string) $routeKey);
    }
}
