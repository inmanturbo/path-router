<?php

namespace Inmanturbo\PathRouter\Handlers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class SimplePathHandler
{
    public function __invoke($viewPath, $routeKey)
    {
        if (View::exists($viewPath)) {

            $contents = View::make($viewPath);
            $response = Response::make($contents, 200);

            foreach (config('path-router.routes.'.$routeKey.'.headers') as $key => $value) {
                if (Str::contains($viewPath, $key)) {
                    $response->withHeaders($value);
                }
            }

            return [true, $response];
        }

        return [false, false];
    }
}
