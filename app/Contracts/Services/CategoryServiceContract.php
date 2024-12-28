<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\Filters\CategoryFilter;
use Illuminate\Support\Collection;

interface CategoryServiceContract
{
    public function list(CategoryFilter $filter): Collection;
}
