<?php
namespace Searching\Prototypes;

use Searching\Interfaces\SearchingInterface;

/**
 * URL数据结构
 */
class UrlPrototype extends BasePrototype
{
    /**
     * 设置URL
     *
     * @param string $alias 路由别名
     * @param SearchingInterface $model 扔给路由的模型
     */
    public function __construct($alias, SearchingInterface $model)
    {
        $this->offsetSet('url', route($alias, $model));
    }

    /**
     * 获取URL
     *
     * @return string
     */
    public function __toString()
    {
        return $this->offsetGet('url');
    }
}
