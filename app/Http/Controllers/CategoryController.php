<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CategoryServiceContract;
use App\Filters\CategoryFilter;
use App\Http\Requests\Category\GetAllCategoriesRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryServiceContract $service,
    )
    {
    }

    /**
     * @param GetAllCategoriesRequest $request
     * @return JsonResponse
     */
    public function all(GetAllCategoriesRequest $request): JsonResponse
    {
        $filterCategory = new CategoryFilter([
            ...$request->validated('filters') ?? []
        ]);

        $categories = $this->service->list($filterCategory);

        return response()->json(CategoryResource::collection($categories)->resolve());
    }
}
