<?php
namespace Searching\Tests\Feature;

use Searching\Tests\TestCase;

/**
 * 功能测试类
 */
class FeatureTest extends TestCase
{
    /**
     * 断言路由是否成功加载
     *
     * @return void
     */
    public function testRoute()
    {
        $this->assertNotEmpty(route('searching'));
    }

    /**
     * 断言搜索接口是否可以调通
     *
     * @return void
     */
    public function testSearch()
    {
        $json = $this->call('GET', 'searching')->getData();
        $this->assertObjectHasAttribute('success', $json);
        $this->assertTrue(data_get($json, 'success'));
    }
}
