<?php

namespace Cosmicvibes\Laraseries\Test;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{


    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application  $app
     * @return Cosmicvibes\Laraseries\LaraseriesServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [\Cosmicvibes\Laraseries\LaraseriesServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testbench'])->run();
    }


}