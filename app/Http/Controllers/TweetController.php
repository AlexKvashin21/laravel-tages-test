<?php

namespace App\Http\Controllers;

use App\Contracts\Services\TweetServiceContract;
use App\DTO\Tweet\CreateTweetDTO;
use App\Events\StoreTweetEvent;
use App\Http\Requests\CreateTweetRequest;
use App\Http\Resources\TweetResource;
use App\Library\Serializer\Serializer;
use App\Models\Category;
use App\Models\Tweet;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

class TweetController extends Controller
{
    public function __construct(
        private readonly TweetServiceContract $service
    )
    {
    }

    public function index(): Response
    {
        $categories = Category::all();
        $tweets = Tweet::query()->latest()->get();

        return Inertia::render('Index', ['categories' => $categories, 'tweets' => TweetResource::collection($tweets)->resolve()]);
    }

    /**
     * @param CreateTweetRequest $request
     * @param Serializer $serializer
     * @return array
     * @throws ExceptionInterface
     */
    public function store(CreateTweetRequest $request, Serializer $serializer)
    {
        $createTweetDTO = $serializer->fromArray(
            $request->validated(),
            CreateTweetDTO::class,
            new CamelCaseToSnakeCaseNameConverter
        );

        $tweet = $this->service->create($createTweetDTO);

        return TweetResource::make($tweet)->resolve();
    }
}
