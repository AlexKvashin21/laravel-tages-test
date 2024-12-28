<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use app\Filters\CategoryFilter;
use Illuminate\Support\Collection;

interface CategoryRepositoryContract
{
    public function list(CategoryFilter $filter): Collection;
}
