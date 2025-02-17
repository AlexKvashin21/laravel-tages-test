<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TweetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'username'       => $this->username,
            'content'        => $this->content,
            'created_at'     => $this->created_at,

            'category'       => !empty($this->category) ? $this->category->title : null
        ];
    }
}
