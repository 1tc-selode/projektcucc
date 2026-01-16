<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Repositories\StudentRepository;
use App\Services\StudentService;

class StudentController extends Controller
{
    public function __construct(
        private StudentRepository $repo,
        private StudentService $service
    ) {}

    public function index(Request $req) {
        return $this->repo->paginate($req);
    }

    public function store(StoreStudentRequest $req) {
        return $this->service->create($req->validated());
    }

    public function destroy(Student $student) {
        $this->service->delete($student);
        return response()->noContent();
    }

    public function show(Student $student) {
        return $student->load('courses');
    }

    public function update(UpdateStudentRequest $req, Student $student) {
        return $this->service->update($student, $req->validated());
    }

    public function assignCourse(Student $student, Course $course) {
        return $this->service->attachToCourse($student, $course->id);
    }

    public function unassignCourse(Student $student, Course $course) {
        return $this->service->detachFromCourse($student, $course->id);
    }
}

