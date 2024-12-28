<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\CategoryRepositoryContract;
use app\Filters\CategoryFilter;
use App\Models\Category;
use Illuminate\Support\Collection;

readonly class CategoryRepository implements CategoryRepositoryContract
{
    public function __construct(
        private Category $model,
    )
    {
    }

    /**
     * @param CategoryFilter $filter
     * @return Collection
     */
    public function list(CategoryFilter $filter): Collection
    {
        return $this->model::filter($filter)->get();
    }
}
