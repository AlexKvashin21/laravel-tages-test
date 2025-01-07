<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CategoryServiceContract;
use App\Contracts\Services\TweetServiceContract;
use App\DTO\Tweet\CreateTweetDTO;
use App\Filters\CategoryFilter;
use App\Filters\TweetFilter;
use App\Http\Requests\CreateTweetRequest;
use App\Http\Requests\GetTweetsRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PaginatedTweetResource;
use App\Http\Resources\TweetResource;
use App\Library\Serializer\Serializer;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

class TweetController extends Controller
{
    public function __construct(
        private readonly TweetServiceContract $service,
        private readonly CategoryServiceContract $categoryService,
    )
    {
    }

    /**
     * @param GetTweetsRequest $request
     * @return Response
     */
    public function index(GetTweetsRequest $request): Response
    {
        $filterCategory = new CategoryFilter([]);
        $filterTweet = new TweetFilter([
            ...$request->validated('filters') ?? []
        ]);

        $categories = $this->categoryService->list($filterCategory);

        $tweets = $this->service->paginatedList(
            $filterTweet,
            $request->validated('page') ?? 1,
            $request->validated('per_page') ?? 10
        );

        return Inertia::render('Index',
            [
                'categories' => CategoryResource::collection($categories)->resolve() ,
                'tweets' => PaginatedTweetResource::make($tweets)->resolve()
            ]);
    }

    /**
     * @param GetTweetsRequest $request
     * @return array
     */
    public function list(GetTweetsRequest $request): array
    {
        $filterTweet = new TweetFilter([
            ...$request->validated('filters') ?? []
        ]);

        $tweets = $this->service->paginatedList(
            $filterTweet,
            $request->validated('page') ?? 1,
            $request->validated('per_page') ?? 10
        );

        return PaginatedTweetResource::make($tweets)->resolve();
    }

    /**
     * @param CreateTweetRequest $request
     * @param Serializer $serializer
     * @return bool
     * @throws ExceptionInterface
     */
    public function store(CreateTweetRequest $request, Serializer $serializer): bool
    {
        $createTweetDTO = $serializer->fromArray(
            $request->validated(),
            CreateTweetDTO::class,
            new CamelCaseToSnakeCaseNameConverter
        );

        $this->service->create($createTweetDTO);

        return true;
    }
}
