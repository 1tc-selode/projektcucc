<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Instructor;
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
        $technologies = [
            'Laravel', 'PHP', 'JavaScript', 'React', 'Vue.js', 'Node.js', 'Python', 'Django', 
            'TypeScript', 'Angular', 'Docker', 'Kubernetes', 'MySQL', 'PostgreSQL', 'MongoDB',
            'Redis', 'AWS', 'Azure', 'Git', 'DevOps', 'CI/CD', 'REST API', 'GraphQL', 'Microservices'
        ];

        $courseTypes = [
            'Alapok', 'Haladó', 'Mester', 'Gyorstalpaló', 'Gyakorlati', 'Elméleti', 
            'Projekt-alapú', 'Intensív', 'Online', 'Hétvégi'
        ];

        $technology = fake()->randomElement($technologies);
        $courseType = fake()->randomElement($courseTypes);
        
        return [
            'title' => $technology . ' ' . $courseType,
            'description' => $this->generateCourseDescription($technology, $courseType),
            'status' => fake()->randomElement(['planned', 'active', 'completed']),
            'difficulty' => fake()->randomElement(['beginner', 'intermediate', 'advanced']),
            'instructor_id' => Instructor::factory(),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Generate a realistic course description.
     */
    private function generateCourseDescription(string $technology, string $courseType): string
    {
        $descriptions = [
            'Laravel' => 'Tanuld meg a Laravel PHP keretrendszert. MVC architektúra, Eloquent ORM, Blade template engine, routing, middleware és authentication.',
            'React' => 'Modern frontend fejlesztés React-tel. Components, hooks, state management, context API és performance optimalizáció.',
            'Vue.js' => 'Vue.js 3 framework elsajátítása. Composition API, reactivity, komponensek, Pinia state management.',
            'Node.js' => 'Backend fejlesztés Node.js-sel. Express.js, RESTful API-k, adatbázis integráció, authentication és deployment.',
            'Python' => 'Python programozási nyelv alapok és haladó technikák. OOP, modulok, csomagkezelés, web scraping.',
            'JavaScript' => 'Modern JavaScript ES6+. Async/await, promises, modulok, DOM manipuláció, event handling.',
            'TypeScript' => 'TypeScript használata nagyobb projektekben. Type safety, interfaces, generics, decorators.',
            'Docker' => 'Containerizáció Docker-rel. Images, containers, volumes, networks, Docker Compose, orchestráció.',
        ];

        $baseDescription = $descriptions[$technology] ?? 'Részletes tanfolyam a ' . $technology . ' technológia elsajátításához.';
        
        $additions = [
            ' Gyakorlati projektek és valós példák.',
            ' Lépésről lépésre haladunk a kezdőtől a haladó szintig.',
            ' Iparági best practice-ek és modern fejlesztési módszertan.',
            ' Projekt-alapú tanulás tapasztalt mentorral.',
            ' Certifikáció lehetőség a kurzus végén.',
        ];

        return $baseDescription . fake()->randomElement($additions);
    }

    /**
     * Indicate that the course is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the course is for beginners.
     */
    public function beginner(): static
    {
        return $this->state(fn (array $attributes) => [
            'difficulty' => 'beginner',
        ]);
    }

    /**
     * Indicate that the course is advanced.
     */
    public function advanced(): static
    {
        return $this->state(fn (array $attributes) => [
            'difficulty' => 'advanced',
        ]);
    }
}
