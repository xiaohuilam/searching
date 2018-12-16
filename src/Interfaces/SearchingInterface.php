<?php
namespace Searching\Interfaces;

use Searching\Prototypes\CategoryNamePrototype;
use Searching\Prototypes\ColumnsPrototype;
use Searching\Prototypes\ShortcutsPrototype;
use Searching\Prototypes\CategoryUrlPrototype;
use Searching\Prototypes\UrlPrototype;

/**
 * 搜索接口
 *
 * @property string $title       抬头
 * @property string $description 描述
 * @property string $link        连接
 */
interface SearchingInterface
{
    /**
     * 主键ID，限制本接口只可以在model使用
     *
     * @return mixed
     */
    public function getKey();

    /**
     * Set the visible attributes for the model.
     *
     * @param  array  $visible
     * @return $this
     */
    public function setVisible(array $visible);

    /**
     * 获取搜索组名
     *
     * @return CategoryNamePrototype
     */
    public static function getSearchableCategoryName() : CategoryNamePrototype;

    /**
     * 获取可被搜索的字段
     *
     * @return ColumnsPrototype
     */
    public static function getSearchableColumns() : ColumnsPrototype;

    /**
     * 获取搜索分组快捷键
     *
     * @return ShortcutsPrototype
     */
    public static function getSearchableShortcuts() : ShortcutsPrototype;

    /**
     * 模型列表路由
     *
     * @return CategoryUrlPrototype
     */
    public static function getSearchableCategoryUrl() : CategoryUrlPrototype;

    /**
     * 模型详情路由
     *
     * @return UrlPrototype
     */
    public function getSearchableUrl() : UrlPrototype;
}
