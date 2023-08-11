<?php

// config for Inmanturbo/PathRouter
return [
    'active' => env('PATH_ROUTER_ACTIVE', true),
    'routes' => [
        // [
        //     'route_prefix' => 'view',
        //     'active' => env('PATH_ROUTER_ACTIVE', true),
        //     'root_dir' => 'www',
        //     'middleware' => [
        //         // 'web',
        //         // 'auth',
        //     ],
        //     'headers' => [

        //         'pdf' => [
        //             'Content-Type' => 'application/pdf',
        //         ],
        //     ],
        //     'handler' => new \Inmanturbo\PathRouter\Handlers\WildcardHandler,
        //     'name' => 'wildcard',
        // ],
        [
            'route_prefix' => 'path',
            'active' => env('PATH_ROUTER_ACTIVE', true),
            'root_dir' => 'www',
            'middleware' => [
                // 'web',
                // 'auth',
            ],
            'headers' => [

                'pdf' => [
                    'Content-Type' => 'application/pdf',
                ],
            ],
            'handler' => new \Inmanturbo\PathRouter\Handlers\SimplePathHandler,
            'name' => 'simple-path',
        ],
    ],
];
