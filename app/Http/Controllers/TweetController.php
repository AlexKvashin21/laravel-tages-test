<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTweetRequest;
use App\Http\Resources\TweetResource;
use App\Models\Category;
use App\Models\Tweet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TweetController extends Controller
{
    public function index(): Response
    {
        $categories = Category::all();
        $tweets = Tweet::query()->latest()->get();

        return Inertia::render('Index', ['categories' => $categories, 'tweets' => TweetResource::collection($tweets)->resolve()]);
    }

    public function store(CreateTweetRequest $request)
    {
        $tweet = Tweet::query()->create([
            'username' => $request->validated('username'),
            'content' => $request->validated('content'),
            'category_id' => $request->validated('category_id')
        ]);

        return TweetResource::make($tweet)->resolve();
    }
}
