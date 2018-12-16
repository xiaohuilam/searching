<?php
namespace Searching\Prototypes;

/**
 * 可被搜索字段数据结构
 */
class ShortcutsPrototype extends BasePrototype
{
    /**
     * 设置可被搜索字段
     *
     * @param string ...$shortcuts
     */
    public function __construct(...$shortcuts)
    {
        foreach ($shortcuts as $shortcut) {
            $this->append($shortcut);
        }
    }
}
