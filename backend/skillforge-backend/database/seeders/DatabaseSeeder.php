<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\Course;
use App\Models\ContactMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 SkillForge Database Seeding Started...');

        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->command->info('✅ Test user created');

        // Create 10 random instructors
        $instructors = collect();
        
        // 5 senior instructors
        $seniorInstructors = Instructor::factory(5)->senior()->create();
        $instructors = $instructors->merge($seniorInstructors);
        
        // 5 junior instructors
        $juniorInstructors = Instructor::factory(5)->junior()->create();
        $instructors = $instructors->merge($juniorInstructors);
        
        $this->command->info('✅ 10 instructors created (5 senior, 5 junior)');

        // Create 10 random students (5 hungarian, 5 international)
        $hungarianStudents = Student::factory(5)->hungarian()->create();
        $internationalStudents = Student::factory(5)->create();
        $allStudents = $hungarianStudents->merge($internationalStudents);
        
        $this->command->info('✅ 10 students created (5 Hungarian, 5 International)');

        // Create 10 random courses with different difficulties
        $beginnerCourses = Course::factory(4)
            ->beginner()
            ->recycle($instructors)
            ->create();
            
        $intermediateCourses = Course::factory(3)
            ->state(['difficulty' => 'intermediate'])
            ->recycle($instructors)
            ->create();
            
        $advancedCourses = Course::factory(3)
            ->advanced()
            ->recycle($instructors)
            ->create();

        $allCourses = $beginnerCourses->merge($intermediateCourses)->merge($advancedCourses);
        $this->command->info('✅ 10 courses created (4 beginner, 3 intermediate, 3 advanced)');

        // Attach students to courses randomly
        $allCourses->each(function ($course) use ($allStudents) {
            // Each course gets 2-6 random students
            $randomStudents = $allStudents->random(rand(2, 6));
            $course->students()->attach($randomStudents->pluck('id'));
        });
        $this->command->info('✅ Students attached to courses randomly');

        // Create 10 contact messages (7 regular, 3 corporate)
        ContactMessage::factory(7)->create();
        ContactMessage::factory(3)->corporate()->create();
        $this->command->info('✅ 10 contact messages created (7 regular, 3 corporate)');

        $this->command->info('🎉 Database seeding completed successfully!');
        $this->command->line('');
        $this->command->info('📊 Summary:');
        $this->command->line('- 1 test user');
        $this->command->line('- 10 instructors (5 senior, 5 junior)');
        $this->command->line('- 10 students (5 Hungarian, 5 International)'); 
        $this->command->line('- 10 courses (4 beginner, 3 intermediate, 3 advanced)');
        $this->command->line('- 10 contact messages (7 regular, 3 corporate)');
        $this->command->line('- Random course-student relationships');
        $this->command->line('');
        $this->command->info('🚀 Ready for testing! Start the server: php artisan serve');
    }
}
