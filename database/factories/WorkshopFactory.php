<?php

namespace Database\Factories;

use Faker\Core\DateTime;
use Faker\Provider\Lorem;
use Illuminate\Database\Eloquent\Factories\Factory;

use function Laravel\Prompts\text;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workshop>
 */
class WorkshopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_id' => 31,
            'user_id' => 3,
            'name' => fake()->word(),
            'description' => fake()->text(180),
            'date' => fake()->dateTime(),
            'duration' => '1 uur',
            'min_pers' => 1,
            'max_pers' => 10,
            'location' => 'C104',
        ];
    }
}
