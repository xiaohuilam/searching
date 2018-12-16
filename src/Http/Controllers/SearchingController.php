<?php
namespace Searching\Http\Controllers;

use Searching\Repositories\SearchingRepository;
use Illuminate\Routing\Controller;
use App\Http\Requests\SearchingRequest;

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
        return $this->repository->search($request->input('search'));
    }
}
