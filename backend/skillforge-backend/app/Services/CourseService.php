<?php

namespace App\Services;

use App\Models\Course;
use App\Events\CourseCreated;

class CourseService
{
    public function create(array $data) {
        $course = Course::create($data);
        broadcast(new CourseCreated($course->load('instructor')))->toOthers();
        return $course;
    }
}
