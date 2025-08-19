<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=> User::factory(),
            'code' => 'STU-' . $this->faker->unique()->numerify('#####'),
            'gender'     => $this->faker->randomElement(['male', 'female']),
            'phone' => $this->faker->optional()->phoneNumber(),
            'address' => $this->faker->optional()->address(),
            'status'  => $this->faker->randomElement(['active', 'on_hold', 'withdrawn']),
        ];
    }
}
