<?php

namespace SergiX44\Nutgram\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use SergiX44\Nutgram\NutgramServiceProvider;

class TestCase extends OrchestraTestCase
{
    /**
     * @param  Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            NutgramServiceProvider::class,
        ];
    }
}
