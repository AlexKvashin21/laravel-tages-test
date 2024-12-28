<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginatedTweetResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'data'         => TweetResource::collection($this->getCollection())->resolve(),
            'per_page'     => $this->perPage(),
            'current_page' => $this->currentPage(),
            'total'        => $this->total(),
            'last_page'    => $this->lastPage(),
        ];
    }
}
