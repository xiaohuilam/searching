<?php

namespace App\Models;

use Searching\Interfaces\SearchingInterface;
use Searching\Prototypes\CategoryNamePrototype;
use Searching\Prototypes\ColumnsPrototype;
use Searching\Prototypes\ShortcutsPrototype;
use Searching\Prototypes\CategoryUrlPrototype;
use Searching\Prototypes\UrlPrototype;

/**
 * 文章公告表
 * App\Models\Article
 *
 * @property int $id
 * @property string $title 抬头
 * @property string $content 内容
 * @property string|null $cover 封面图
 * @property int $user_id 用户id
 * @property int $status 发布状态 0草稿 1已发布
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article query()
 * @mixin \Eloquent
 */
class Article extends BaseModel implements SearchingInterface
{
    protected $fillable = ['title', 'content', 'user_id', 'cover', ];

    /**
     * 获取搜索组名
     *
     * @return CategoryNamePrototype
     */
    public static function getSearchableCategoryName()
    {
        return new CategoryNamePrototype('公告');
    }

    /**
     * 获取可被搜索的字段
     *
     * @return ColumnsPrototype
     */
    public static function getSearchableColumns()
    {
        return new ColumnsPrototype('title', 'content');
    }

    /**
     * 获取搜索分组快捷键
     *
     * @return ShortcutsPrototype
     */
    public static function getSearchableShortcuts()
    {
        return new ShortcutsPrototype('xw', 'gg', 'wz');
    }

    /**
     * 模型列表路由
     *
     * @return CategoryUrlPrototype
     */
    public static function getSearchableCategoryUrl()
    {
        return new CategoryUrlPrototype('article.index');
    }

    /**
     * 模型详情路由
     *
     * @return CategoryUrlPrototype
     */
    public function getSearchableUrl()
    {
        return new UrlPrototype('article.show', $this);
    }
}
