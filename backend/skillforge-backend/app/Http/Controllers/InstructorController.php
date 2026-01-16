<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Http\Requests\StoreInstructorRequest;
use App\Http\Requests\UpdateInstructorRequest;
use App\Repositories\InstructorRepository;
use App\Services\InstructorService;

class InstructorController extends Controller
{
    public function __construct(
        private InstructorRepository $repo,
        private InstructorService $service
    ) {}

    public function index(Request $req) {
        return $this->repo->paginate($req);
    }

    public function store(StoreInstructorRequest $req) {
        return $this->service->create($req->validated());
    }

    public function show(Instructor $instructor) {
        return $instructor->load('courses');
    }

    public function update(UpdateInstructorRequest $req, Instructor $instructor) {
        return $this->service->update($instructor, $req->validated());
    }

    public function destroy(Instructor $instructor) {
        try {
            $this->service->delete($instructor);
            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Cannot delete instructor with existing courses',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}

