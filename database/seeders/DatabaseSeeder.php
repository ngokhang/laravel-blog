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
        // User::factory(10)->create();
        Category::create([
            'slug' => 'general',
            'name' => 'General'
        ]);
        Category::create([
            'slug' => 'eating',
            'name' => 'Eating'
        ]);
        Category::create([
            'slug' => 'sleeping',
            'name' => 'Sleeping'
        ]);
        Category::create([
            'slug' => 'coding',
            'name' => 'Coding'
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@abc.com',
            'password' => bcrypt('123456'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'user_1',
            'email' => 'user_1@abc.com',
            'password' => bcrypt('123456'),
            'role' => 'user'
        ]);
        // Post::factory(20)->create();
        // CategoryPost::factory(10)->create();
    }
}
