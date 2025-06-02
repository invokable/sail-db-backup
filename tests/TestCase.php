<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Application;
use Revolution\Sail\Backup\SailBackupServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Load package service provider.
     *
     * @param  Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [
            SailBackupServiceProvider::class,
        ];
    }

    /**
     * Load package alias.
     *
     * @param  Application  $app
     */
    protected function getPackageAliases($app): array
    {
        return [
            //
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.connections', [
            'mysql' => [
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => 'test',
                'username' => 'user',
                'password' => 'password',
            ],
            'mysql2' => [
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => 'test2',
                'username' => 'user',
                'password' => 'password',
            ],
        ]);
    }
}
