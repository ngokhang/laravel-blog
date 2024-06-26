<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 10),
            // 'category_id' => 1,
            'slug' => fake()->slug(3),
            'title' => 'Tiêu đề bài viết',
            'description' => 'Miêu tả bài viết',
            'content' => fake()->paragraph(),
        ];
    }
}
