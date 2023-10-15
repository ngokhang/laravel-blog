<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Category::create([
            'name' => 'Eating'
        ]);
        Category::create([
            'name' => 'Sleeping'
        ]);
        Category::create([
            'name' => 'Coding'
        ]);
        Post::factory(20)->create();
        CategoryPost::factory(10)->create();
    }
}
