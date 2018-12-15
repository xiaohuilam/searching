<?php
namespace Searching\Prototypes;

/**
 * 分类URL数据结构
 */
class CategoryUrlPrototype extends BasePrototype
{
    /**
     * 设置分类URL
     *
     * @param string $alias 路由别名
     */
    public function __construct(string $alias)
    {
        $this->offsetSet('url', route($alias));
    }

    /**
     * 获取分类URL
     *
     * @return string
     */
    public function __toString()
    {
        return $this->offsetGet('url');
    }
}
