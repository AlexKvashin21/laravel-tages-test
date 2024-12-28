<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\DTO\Tweet\CreateTweetDTO;
use App\DTO\Tweet\UpdateTweetDTO;
use app\Filters\TweetFilter;
use App\Models\Tweet;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TweetRepositoryContract
{
    public function paginatedList(TweetFilter $filter, int $page = 1, int $perPage = 10): LengthAwarePaginator;
    public function list(TweetFilter $filter): Collection;
    public function findById(int $id): ?Tweet;
    public function findOrFailById(int $id): Tweet;
    public function create(CreateTweetDTO $createTweetDTO): Tweet;
    public function update(UpdateTweetDTO $updateTweetDTO): bool;
    public function delete(int $id): bool;
}
