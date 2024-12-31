<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Category::factory()->count(10)->create();

        $categories = [
            'Искусство',
            'Котики',
            'Школа',
            'Фильмы',
            'Программирование',
        ];

        foreach ($categories as $category) {
            Category::query()->create([
                'title' => $category
            ]);
        }

    }
}
