<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\TweetRepositoryContract;
use app\Filters\TweetFilter;
use App\Library\Serializer\Serializer;
use App\Models\Tweet;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use App\DTO\Tweet\CreateTweetDTO;
use App\DTO\Tweet\UpdateTweetDTO;

readonly class TweetRepository implements TweetRepositoryContract
{
    public function __construct(
        private Tweet      $model,
        private Serializer $serializer,
    )
    {
    }

    /**
     * @param TweetFilter $filter
     * @param int $page
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginatedList(TweetFilter $filter, int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model::filter($filter)->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @param TweetFilter $filter
     * @return Collection
     */
    public function list(TweetFilter $filter): Collection
    {
        return $this->model::filter($filter)->get();
    }

    /**
     * @param int $id
     * @return ?Tweet
     */
    public function findById(int $id): ?Tweet
    {
        /** @var Tweet */
        return $this->model::query()->find($id);
    }

    /**
     * @param int $id
     * @return Tweet
     */
    public function findOrFailById(int $id): Tweet
    {
        /** @var Tweet */
        return $this->model::query()->findOrFail($id);
    }

    /**
     * @param UpdateTweetDTO $updateTweetDTO
     * @return bool
     * @throws ExceptionInterface
     * @throws \Exception
     */
    public function update(UpdateTweetDTO $updateTweetDTO): bool
    {
        return (bool)$this->model::query()
            ->where('id', $updateTweetDTO->getId())
            ->update($this->serializer->toArray($updateTweetDTO, new CamelCaseToSnakeCaseNameConverter));
    }

    /**
     * @param CreateTweetDTO $createTweetDTO
     * @return Tweet
     * @throws ExceptionInterface
     * @throws \Exception
     */
    public function create(CreateTweetDTO $createTweetDTO): Tweet
    {
        /** @var Tweet $Tweet */
        $Tweet = $this->model::query()
            ->create($this->serializer->toArray($createTweetDTO, new CamelCaseToSnakeCaseNameConverter));

        if (is_null($Tweet->id)) {
            throw new \Exception("Error occurred while creating Tweet");
        }

        return $Tweet;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return (bool)$this->model::query()->where('id', $id)->delete();
    }
}
