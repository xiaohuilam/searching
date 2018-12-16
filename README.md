# Searching

Laravel 顶级搜索功能

[![Build Status](https://travis-ci.com/xiaohuilam/searching.svg?branch=php5)](https://travis-ci.com/xiaohuilam/searching)

## Install

请使用 composer 安装

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

```bash
php artisan vendor:publish --tag=searching
```

## Configuration

### 声明模型

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

### 模型改造

打开 `app/Models/User.php`，按照 `examples/Models/Article.php` 的方式实现 `Searching\Interfaces\SearchingInterface` 接口，并加好如下方法（具体用途请参照 `SearchingInterface` 注释）

* [getSearchableCategoryName()](https://github.com/xiaohuilam/searching/blob/php5/src/Interfaces/SearchingInterface.php#L22-L27)
* [getSearchableColumns()](https://github.com/xiaohuilam/searching/blob/php5/src/Interfaces/SearchingInterface.php#L29-L34)
* [getSearchableShortcuts()](https://github.com/xiaohuilam/searching/blob/php5/src/Interfaces/SearchingInterface.php#L36-L41)
* [getSearchableCategoryUrl()](https://github.com/xiaohuilam/searching/blob/php5/src/Interfaces/SearchingInterface.php#L43-L48)
* [getSearchableUrl()](https://github.com/xiaohuilam/searching/blob/php5/src/Interfaces/SearchingInterface.php#L50-L55)

### 模板引入

在你的导航条中，加入 `@include('layouts.search')`

```html
<ul class="nav navbar-nav">
    <li class="{{is('home', 'active')}}"><a href="{{ route('home') }}">首页</a></li>
    <!-- 原有的导航 -->
    @include('layouts.search')
</ul>
```

在 `resources/views/layouts/search.blade.php` 中的

```blade
@push('script')
...
@endpush
```

所以请为了保证 js 能正常加载, 确认你的顶级模板会在 `</body>` 前 (stack 只有 laravel5.2+ 支持)

```blade
@stack('script)
```

如果你使用的 laravel 5.1 以下版本，请手工添加

```blade
@yield('seaching-js')
```

### 权限检查

打开 `app/Http/Requests/SearchingRequest.php`, 修改

```php
public function authorize()
{
    return true; // 返回 `true` 时候表示可以搜索
}
```

## Demo

![demo.png](https://i.loli.net/2018/12/15/5c14e92b743c4.png)
