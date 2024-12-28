<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder as BuilderContract;

interface FilterContract
{
    public function apply(BuilderContract $builder);
}
