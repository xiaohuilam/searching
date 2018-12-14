<?php
namespace Searching\Http\Controllers;

use Searching\Repositories\SearchingRepository;

class SearchingController
{
    /**
     * 存储器
     *
     * @var \Searching\Repositories\SearchingRepository
     */
    protected $repository;

    public function __construct(SearchingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 搜索
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->repository->list(request()->input('search'));
    }
}
