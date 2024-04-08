<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
 /**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Get all existing category IDs
        $categoryIds = Category::pluck('id')->toArray();

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'image' => $this->faker->imageUrl(),
            'parent_id' => count($categoryIds) > 0 ? $this->faker->randomElement($categoryIds) : null,
        ];
    }
}
