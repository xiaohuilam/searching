# Searching

Laravel 顶级搜索功能


## Install

```bash
composer require xiaohuilam/searching
php artisan vendor:publish --tag=searching
```

## Configuration

修改 `config/search.php`

```php
<?php
return [
    'models' => [
        App\Models\User::class,
        放入你的模型...
    ],
];
```

打开 `app/Models/User.php`
```php
<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Searching\Interfaces\SearchingInterface;

class User extends Authenticatable implements SearchingInterface
{
    //...


    /**
     * 获取搜索组名
     *
     * @return string
     */
    public static function getSearchableCategoryName()
    {
        return '用户'; // 在搜索框左边类目显示
    }

    /**
     * 获取可被搜索的字段
     *
     * @return \Illuminate\Support\Collection|Countable|array
     */
    public static function getSearchableColumns()
    {
        return ['name', 'email']; // 可被搜索的字段
    }

    /**
     * 获取搜索分组快捷键
     *
     * @return \Illuminate\Support\Collection|Countable|array
     */
    public static function getSearchableShortcuts()
    {
        return ['yh', 'zh', 'gly']; // 简短词
    }

    /**
     * 模型详情路由
     *
     * @return string
     */
    public function getSearchableUrl()
    {
        return route('user.show', $this); // 单个结果的URL
    }

    /**
     * 模型列表路由
     *
     * @return string
     */
    public static function getSearchableCategoryUrl()
    {
        return route('user.index'); // 分类URL
    }
}
```

## Demo

![demo.png](https://wantu-kw0-asset007-hz.oss-cn-hangzhou.aliyuncs.com/FBARMfQr491s61WNxUB.png)