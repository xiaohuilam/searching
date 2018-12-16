<?php
namespace Searching\Http\Controllers;

use App\Http\Requests\SearchingRequest;
use Illuminate\Routing\Controller;
use Searching\Repositories\SearchingRepository;

class SearchingController extends Controller
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
    public function index(SearchingRequest $request)
    {
        /**
         * @var array
         */
        $search = $request->input('search');
        return $this->repository->search($search);
    }
}
