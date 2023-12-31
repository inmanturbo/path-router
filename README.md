# This is my package path-router

[![Latest Version on Packagist](https://img.shields.io/packagist/v/inmanturbo/path-router.svg?style=flat-square)](https://packagist.org/packages/inmanturbo/path-router)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/inmanturbo/path-router/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/inmanturbo/path-router/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/inmanturbo/path-router/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/inmanturbo/path-router/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/inmanturbo/path-router.svg?style=flat-square)](https://packagist.org/packages/inmanturbo/path-router)

## Installation

You can install the package via composer:

```bash
composer require inmanturbo/path-router
```

```bash
php artisan vendor:publish --tag="path-router-config"
```

This is the contents of the published config file:

```php
return [
    'active' => env('PATH_ROUTER_ACTIVE', true),
    'routes' => [
        [
            'route_prefix' => 'view',
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
            'handler' => new \Inmanturbo\PathRouter\Handlers\PathBasedViewResponseHandler,
        ],
    ],
];
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [inmanturbo](https://github.com/inmanturbo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
