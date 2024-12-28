<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use Filterable;

    protected $fillable = [
        'username',
        'content',
        'category_id'
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }
}
