<?php
namespace Searching\Prototypes;

/**
 * 分类名字数据结构
 */
class CategoryNamePrototype extends BasePrototype
{
    /**
     * 设置分类名字
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->offsetSet('name', $name);
    }

    /**
     * 获取分类名字
     *
     * @return string
     */
    public function __toString()
    {
        return $this->offsetGet('name');
    }
}
