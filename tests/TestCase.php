<?php

namespace Inmanturbo\PathRouter\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Inmanturbo\PathRouter\PathRouterServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['view.paths' => [__DIR__.'/resources/views']]);
        
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Inmanturbo\\PathRouter\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            PathRouterServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_path-router_table.php.stub';
        $migration->up();
        */
    }
}
