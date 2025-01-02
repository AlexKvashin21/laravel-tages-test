<?php

namespace App\Jobs;

use App\Contracts\Repositories\TweetRepositoryContract;
use App\DTO\Tweet\CreateTweetDTO;
use App\Events\StoreTweetEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TweetJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly CreateTweetDTO $createTweetDTO,
        private readonly TweetRepositoryContract $tweetRepository
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tweet = $this->tweetRepository->create($this->createTweetDTO);

        broadcast(new StoreTweetEvent($tweet));
    }
}
