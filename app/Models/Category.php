<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'title',
    ];

    public function tweets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->HasMany(\App\Models\Tweet::class, 'category_id');
    }
}
