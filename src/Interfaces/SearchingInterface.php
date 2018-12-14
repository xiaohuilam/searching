<?php
namespace Searching\Interfaces;

/**
 * 搜索接口
 */
interface SearchingInterface
{
    /**
     * 获取搜索组名
     *
     * @return string
     */
    public static function getSearchableCategoryName();

    /**
     * 获取可被搜索的字段
     *
     * @return \Illuminate\Support\Collection|array
     */
    public static function getSearchableColumns();

    /**
     * 获取搜索分组快捷键
     *
     * @return \Illuminate\Support\Collection|array
     */
    public static function getSearchableShortcuts();

    /**
     * 模型列表路由
     *
     * @return string
     */
    public static function getSearchableCategoryUrl();

    /**
     * 模型详情路由
     *
     * @return string
     */
    public function getSearchableUrl();
}
