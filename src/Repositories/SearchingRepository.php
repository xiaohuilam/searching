<?php

namespace Searching\Repositories;

use Searching\Interfaces\SearchingInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
     * @param  string                                   $keyword
     * @param  \Searching\Interfaces\SearchingInterface $model
     * @return \Illuminate\Support\Collection
     */
    protected function shortcut($keyword, $model)
    {
        $category_name = (string) $model::getSearchableCategoryName();
        $list = collect([]);
        if (in_array(strtolower($keyword), (array) $model::getSearchableShortcuts())) {
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
     * @param  string                                   $keyword
     * @param  \Searching\Interfaces\SearchingInterface $model
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
            $item->link = (string) $item::getSearchableCategoryUrl();
            $list->push($item);

            $content = $this->search(['keyword' => data_get($keywords, 1), 'models' => [$model, ]])->getOriginalContent();
            $list = $list->merge(data_get($content, 'data.' . $category_name));
        }
        return $list;
    }

    /**
     * 列表
     *
     * @param  array $search
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

            /**
             * @var \Illuminate\Database\Query\Builder
             */
            $query = new $model;

            foreach ($searches as $column) {
                $query = $query->orWhere($column, 'LIKE', '%' . $keyword . '%');
            }

            $list = $query->take(10)->get();
            $list->transform(
                function (SearchingInterface $item) use ($searches) {
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
