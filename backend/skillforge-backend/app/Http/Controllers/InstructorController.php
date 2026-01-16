<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Http\Requests\StoreInstructorRequest;
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
}

