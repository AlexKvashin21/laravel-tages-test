<?php

namespace App\Services;

use App\Contracts\Repositories\CategoryRepositoryContract;
use App\Contracts\Services\CategoryServiceContract;
use App\DTO\Category\CreateCategoryDTO;
use App\Events\StoreCategoryEvent;
use App\Filters\CategoryFilter;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

readonly class CategoryService implements CategoryServiceContract
{
    public function __construct(
        private CategoryRepositoryContract $repository,
    )
    {
    }

    /**
     * @param CategoryFilter $filter
     * @return Collection
     */
    public function list(CategoryFilter $filter): Collection
    {
        return $this->repository->list($filter);
    }
}
