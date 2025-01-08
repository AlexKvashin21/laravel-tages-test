<?php

namespace App\Http\Controllers;

use App\Contracts\Services\TweetServiceContract;
use App\DTO\Tweet\CreateTweetDTO;
use App\Filters\TweetFilter;
use App\Http\Requests\CreateTweetRequest;
use App\Http\Requests\GetTweetsRequest;
use App\Http\Resources\PaginatedTweetResource;
use App\Library\Serializer\Serializer;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

class TweetController extends Controller
{
    public function __construct(
        private readonly TweetServiceContract $service
    )
    {
    }

    /**
     * @param GetTweetsRequest $request
     * @return JsonResponse
     */
    public function list(GetTweetsRequest $request): JsonResponse
    {
        $filterTweet = new TweetFilter([
            ...$request->validated('filters') ?? []
        ]);

        $tweets = $this->service->paginatedList(
            $filterTweet,
            $request->validated('page') ?? 1,
            $request->validated('per_page') ?? 10
        );

        return response()->json(PaginatedTweetResource::make($tweets)->resolve());
    }

    /**
     * @param CreateTweetRequest $request
     * @param Serializer $serializer
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function store(CreateTweetRequest $request, Serializer $serializer): JsonResponse
    {
        $createTweetDTO = $serializer->fromArray(
            $request->validated(),
            CreateTweetDTO::class,
            new CamelCaseToSnakeCaseNameConverter
        );

        $this->service->create($createTweetDTO);

        return response()->json(true);
    }
}
