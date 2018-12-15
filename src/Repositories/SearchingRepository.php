<?php

namespace Searching\Repositories;

use App\Models\Product;
use App\Models\User;
use App\Models\Article;
use App\Models\Guestbook;
use App\Models\Slide;
use App\Models\SiteConfig;
use App\Repositories\Abstracts\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Searching\Interfaces\SearchingInterface;

/**
 * 检索
 */
class SearchingRepository
{
    /**
     * 模型们
     *
     * @var \Searching\Interfaces\SearchingInterface[]|\Illuminate\Database\Eloquent\Model[]|array
     */
    protected $models;

    /**
     * 搜索 Model::SHORTCUT
     *
     * @param  string $keyword
     * @param  \Searching\Interfaces\SearchingInterface|\Illuminate\Database\Eloquent\Model|string $model
     * @return \Illuminate\Support\Collection
     */
    protected function shortcut($keyword, $model)
    {
        $category_name = constant($model . '::CATEGORY');
        $list = collect([]);
        if (in_array(strtolower($keyword), $model::getSearchableShortcuts())) {
            $item = new $model();
            $item->title = $category_name;
            $item->name = $category_name;
            $item->description = $category_name;
            $item->id = 0;
            $item->link = route('index');
            $list->push($item);
        }
        return $list;
    }

    /**
     * 搜索 Model::SHORTCUT
     *
     * @param  string $keyword
     * @param  \Searching\Interfaces\SearchingInterface|\Illuminate\Database\Eloquent\Model|string $model
     * @return \Illuminate\Support\Collection
     */
    protected function categorySearch($keyword, $model)
    {
        $keywords = explode(':', $keyword);
        $keyword = $keywords[0];

        $category_name = (string) $model::getSearchableCategoryName();
        $list = collect([]);
        if (collect((array) $model::getSearchableShortcuts())->contains($keyword)) {
            $item = new $model();
            $item->title = '以下搜索的是: ' . $category_name;
            $item->name = $category_name;
            $item->description = $category_name;
            $item->id = 0;
            $item->link = route($model::getModelNameLower() . '.index');
            $list->push($item);

            $content = $this->list(['keyword' => data_get($keywords, 1), 'models' => [$model, ]])->getOriginalContent();
            $list = $list->merge(data_get($content, 'data.' . $category_name));
        }
        return $list;
    }

    /**
     * 列表
     *
     * @param  array  $search
     * @return \Illuminate\Http\JsonResponse
     */
    public function search($search = [])
    {
        $keyword = data_get($search, 'keyword');

        $data = collect([]);
        $count = 0;
        $this->models = config('search.models', []);
        if (data_get($search, 'models')) {
            $this->models = data_get($search, 'models');
        }

        $list = collect([]);

        foreach ($this->models as $model) {
            $category_name = (string) $model::getSearchableCategoryName();

            $fillable = app($model)->getFillable();
            $searches = $model::getSearchableColumns();
            $query = new $model;

            foreach ($searches as $column) {
                $query = $query->orWhere($column, 'LIKE', '%' . $keyword . '%');
            }

            $list = $query->take(10)->get();
            $list->transform(
                function (SearchingInterface $item) use ($searches) {
                    $route = $item::getModelNameLower();
                    $item->title = data_get($item, $searches['title']);
                    $item->description = data_get($item, $searches['description']);

                    if ($item->getKey()) {
                        $item->link = (string) $item->getSearchableUrl();
                    } else {
                        $item->link = (string) $item::getSearchableCategoryUrl();
                    }
                    $item->description = Str::limit($item->description, 90);

                    $item->setVisible(['id', 'title', 'description', 'link', ]);
                    return $item;
                }
            );

            $list = $this->categorySearch($keyword, $model)->merge($list);
            $count += $list->count();

            $data[$category_name] = $list;
        }

        $limit = 5;
        do {
            $limit--;
            $data->transform(
                function (Collection $list) use ($limit) {
                    $list = $list->take($limit);
                    return $list;
                }
            );
            if ($list->count() <= 15) {
                break;
            }
        } while (true);

        return response()->json(
            [
                'success' => true,
                'data' => $data,
            ]
        );
    }
}
