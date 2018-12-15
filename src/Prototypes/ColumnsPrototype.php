<?php
namespace Searching\Prototypes;

/**
 * 可被搜索字段数据结构
 */
class ColumnsPrototype extends BasePrototype
{
    /**
     * 设置可被搜索字段
     *
     * @param string $title
     * @param string $description
     */
    public function __construct($title, $description)
    {
        $this->offsetSet('title', $title);
        $this->offsetSet('description', $description);
    }
}
