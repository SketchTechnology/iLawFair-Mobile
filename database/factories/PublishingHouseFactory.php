<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PublishingHouse;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublishingHouse>
 */
class PublishingHouseFactory extends Factory
{
    protected $model = PublishingHouse::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'image' => $this->faker->imageUrl(),
            'address' => $this->faker->address,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
