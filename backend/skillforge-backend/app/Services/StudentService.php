<?php

namespace App\Services;

use App\Models\Student;

class StudentService
{
    public function create(array $data)
    {
        return Student::create($data);
    }

    public function update(Student $student, array $data)
    {
        $student->update($data);
        return $student;
    }

    public function delete(Student $student)
    {
        return $student->delete();
    }

    public function attachToCourse(Student $student, $courseId)
    {
        $student->courses()->attach($courseId);
        return $student->load('courses');
    }

    public function detachFromCourse(Student $student, $courseId)
    {
        $student->courses()->detach($courseId);
        return $student->load('courses');
    }
}