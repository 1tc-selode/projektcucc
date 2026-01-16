<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $messageTemplates = [
            'Üdvözlöm! Kérdésem lenne a {course} kurzussal kapcsolatban. Mikor kezdődik a következő csoport?',
            'Jó napot! Szeretnék információt kérni a {course} tanfolyamról. Milyen előismeretek szükségesek?',
            'Sziasztok! A {course} kurzus díjával kapcsolatban szeretnék érdeklődni. Van lehetőség részletfizetésre?',
            'Kedves SkillForge csapat! Érdekel a {course} képzés. Tudnának segíteni az anyagokkal kapcsolatban?',
            'Hello! I would like to know more about the {course} course. Is it available in English?',
            'Üdvözlöm! Online formában is elérhető a {course} kurzus? Külföldről szeretnék csatlakozni.',
            'Jó estét! Van-e próbaidőszak a {course} tanfolyam esetében? Előzetes tapasztalás nélkül is kezdhető?',
            'Kedves Kollégák! Céges képzésre keresnénk {course} oktatót. Tudnak segíteni?',
            'Szia! A {course} kurzus után milyen munkalehetőségek nyílnak meg? Van-e állásbörze?',
            'Üdvözlet! Sajnos lemaradtam a {course} kurzusról. Mikor indul a következő?'
        ];

        $courses = [
            'Laravel', 'React', 'Vue.js', 'Node.js', 'Python', 'JavaScript', 
            'TypeScript', 'Docker', 'PHP', 'Angular', 'DevOps'
        ];

        $template = fake()->randomElement($messageTemplates);
        $course = fake()->randomElement($courses);
        
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'message' => str_replace('{course}', $course, $template),
            'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the message is urgent.
     */
    public function urgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'message' => '[SÜRGŐS] ' . $attributes['message'],
        ]);
    }

    /**
     * Indicate that the message is from a company.
     */
    public function corporate(): static
    {
        $companies = [
            'TechCorp Kft.', 'InnovateIT Ltd.', 'DigitalSolutions Zrt.', 
            'CodeFactory Bt.', 'WebDev Studios', 'DataScience Pro'
        ];
        
        return $this->state(fn (array $attributes) => [
            'name' => fake()->name() . ' (' . fake()->randomElement($companies) . ')',
            'email' => fake()->unique()->companyEmail(),
            'message' => 'Céges megkeresés: ' . $attributes['message'],
        ]);
    }
}
