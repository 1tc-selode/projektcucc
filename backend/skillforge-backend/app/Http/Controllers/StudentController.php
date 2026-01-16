<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
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
}

