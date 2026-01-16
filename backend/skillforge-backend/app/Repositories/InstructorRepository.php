<?php

namespace App\Repositories;

use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorRepository
{
    public function paginate(Request $req)
    {
        return Instructor::withCount('courses')
            ->when($req->search, fn($q) =>
                $q->where('name', 'like', '%' . $req->search . '%')
                  ->orWhere('email', 'like', '%' . $req->search . '%'))
            ->orderBy(
                $req->sort ?? 'name',
                $req->dir ?? 'asc'
            )
            ->paginate(10);
    }

    public function findById($id)
    {
        return Instructor::with('courses')->findOrFail($id);
    }

    public function all()
    {
        return Instructor::withCount('courses')->get();
    }
}