<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Conference', 'slug' => 'conference'],
            ['name' => 'Workshop', 'slug' => 'workshop'],
            ['name' => 'Meetup', 'slug' => 'meetup'],
            ['name' => 'Social', 'slug' => 'social'],
            ['name' => 'Sports', 'slug' => 'sports'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
