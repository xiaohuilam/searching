<?php

namespace Searching\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Searching\Providers\SearchingServiceProvider;
use Illuminate\Encryption\Encrypter;

/**
 * 测试用例抽象类
 */
abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [SearchingServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        if (method_exists(Encrypter::class, 'generateKey')) {
            $key = 'base64:' . base64_encode(Encrypter::generateKey('AES-256-CBC'));
        } else {
            $key = Str::random(32);
        }

        $app->config->set('app.key', $key);
    }
}
