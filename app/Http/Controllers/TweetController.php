<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTweetRequest;
use App\Models\Category;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TweetController extends Controller
{
    public function index(): View
    {
        $categories = Category::all();
        $tweets = Tweet::all();

        return view('index', ['categories' => $categories, 'tweets' => $tweets]);
    }

    public function store(CreateTweetRequest $request)
    {
        Tweet::query()->create([
            'username' => $request->validated('username'),
            'content' => $request->validated('content'),
            'category_id' => $request->validated('category_id')
        ]);

        return redirect()->route('tweet.index');
    }
}
