<?php

namespace Database\Factories;

use App\Models\Student;
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the student is from Hungary.
     */
    public function hungarian(): static
    {
        $hungarianFirstNames = ['Péter', 'János', 'Zoltán', 'László', 'Gábor', 'András', 'István', 'Tamás', 'Attila', 'Zsolt', 
                               'Anna', 'Éva', 'Katalin', 'Erzsébet', 'Mária', 'Judit', 'Andrea', 'Krisztina', 'Mónika', 'Gabriella'];
        $hungarianLastNames = ['Nagy', 'Kovács', 'Tóth', 'Szabó', 'Horváth', 'Varga', 'Kiss', 'Molnár', 'Németh', 'Farkas'];
        
        return $this->state(fn (array $attributes) => [
            'name' => fake()->randomElement($hungarianLastNames) . ' ' . fake()->randomElement($hungarianFirstNames),
        ]);
    }
}
