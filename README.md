# Searching

Laravel 顶级搜索功能

[![Build Status](https://travis-ci.com/xiaohuilam/searching.svg?branch=php5)](https://travis-ci.com/xiaohuilam/searching)

## Install

```bash
composer require xiaohuilam/searching
```

打开 `config/app.php`，在 `providers` 添加如下
```php
"providers" => [
    // ...
    // 你原先 providers 的后面加下面这一行
    Searching\Providers\SearchingServiceProvider::class,
]
```

发布配置文件、搜索框模板和 js
```
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

打开 `app/Models/User.php`，按照 `examples/Models/Article.php` 的方式实现 `Searching\Interfaces\SearchingInterface` 接口，并加好如下方法（具体用途请参照 `SearchingInterface` 注释）

 * getSearchableCategoryName
 * getSearchableColumns
 * getSearchableShortcuts
 * getSearchableCategoryUrl
 * getSearchableUrl

## Demo

![demo.png](https://i.loli.net/2018/12/15/5c14e92b743c4.png)
