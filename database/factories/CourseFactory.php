<?php

namespace Database\Factories;

use App\Enums\DifficultyLevel;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $cases = array_column(DifficultyLevelStatus::cases(), 'value');

        return [
            'name' => fake()->realText(10),
            'description' => fake()->realText(180),
            'difficulty_level' => fake()->randomElement(DifficultyLevel::cases()),
            'language_id' => fake()->randomElement(Language::all()->pluck('id')),
            'category_id' => fake()->randomElement(Category::all()->pluck('id')),
            'price' => fake()->numberBetween(0, 300),
        ];
    }
}
