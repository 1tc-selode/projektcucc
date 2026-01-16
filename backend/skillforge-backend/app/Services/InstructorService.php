<?php

namespace App\Services;

use App\Models\Instructor;

class InstructorService
{
    public function create(array $data)
    {
        return Instructor::create($data);
    }

    public function update(Instructor $instructor, array $data)
    {
        $instructor->update($data);
        return $instructor;
    }

    public function delete(Instructor $instructor)
    {
        // Check if instructor has courses
        if ($instructor->courses()->count() > 0) {
            throw new \Exception('Cannot delete instructor with existing courses');
        }
        
        return $instructor->delete();
    }
}