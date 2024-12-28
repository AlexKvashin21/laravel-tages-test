<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class TweetFilter extends AbstractFilter
{
    private const ID = 'id';

    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [
            self::ID   => [ $this, 'id'  ],
        ];
    }

    public function id(Builder $builder, int $id): void
    {
        $builder->where('id', $id);
    }
}
