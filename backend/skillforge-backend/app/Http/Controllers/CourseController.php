<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;
use App\Repositories\CourseRepository;
use App\Services\CourseService;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    public function __construct(
        private CourseRepository $repo,
        private CourseService $service
    ) {}

    public function index(Request $req) {
        return $this->repo->paginate($req);
    }

    public function store(StoreCourseRequest $req) {
        return $this->service->create($req->validated());
    }

    public function show(Course $course) {
        return $course->load('students','instructor');
    }

    public function update(UpdateCourseRequest $req, Course $course) {
        $course->update($req->validated());
        return $course;
    }

    public function destroy(Course $course) {
        $course->delete();
        return response()->noContent();
    }

    public function attachStudent(Course $course, Student $student) {
        $course->students()->attach($student->id);
        return response()->json([
            'message' => 'Student successfully attached to course',
            'course' => $course->load(['instructor', 'students'])
        ]);
    }

    public function detachStudent(Course $course, Student $student) {
        $course->students()->detach($student->id);
        return response()->json([
            'message' => 'Student successfully detached from course',
            'course' => $course->load(['instructor', 'students'])
        ]);
    }
}
