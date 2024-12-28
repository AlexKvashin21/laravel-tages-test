<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\DTO\Tweet\CreateTweetDTO;
use App\DTO\Tweet\UpdateTweetDTO;
use App\Filters\TweetFilter;
use App\Models\Tweet;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TweetServiceContract
{
    public function paginatedList(TweetFilter $filter, int $page = 1, int $perPage = 10): LengthAwarePaginator;
    public function list(TweetFilter $filter): Collection;
    public function get(int $id): Tweet;

//    public function update(UpdateTweetDTO $updateTweetDTO): bool;
    public function create(CreateTweetDTO $createTweetDTO): Tweet;
    public function delete(int $id): bool;
}
