<?php

namespace Searching\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Searching\Providers\SearchingServiceProvider;

/**
 * 测试用例抽象类
 */
abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [SearchingServiceProvider::class];
    }
}