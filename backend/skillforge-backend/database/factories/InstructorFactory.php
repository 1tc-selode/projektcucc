<?php

namespace Database\Factories;

use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instructor>
 */
class InstructorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'created_at' => fake()->dateTimeBetween('-2 years', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the instructor is senior.
     */
    public function senior(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Dr. ' . fake()->name(),
        ]);
    }

    /**
     * Indicate that the instructor is junior.
     */
    public function junior(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => fake()->firstName() . ' ' . fake()->lastName(),
        ]);
    }
}
