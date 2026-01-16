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
        $expertiseOptions = [
            'Web Development', 'Mobile App Development', 'Data Science', 
            'Machine Learning', 'DevOps', 'Cloud Computing',
            'Cybersecurity', 'UI/UX Design', 'Backend Development',
            'Frontend Development', 'Full-Stack Development', 'Python Programming'
        ];
        
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->optional(0.8)->phoneNumber(),
            'expertise' => fake()->randomElement($expertiseOptions),
            'bio' => fake()->optional(0.7)->realText(200),
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
