<?php

namespace App\Repositories;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentRepository
{
    public function paginate(Request $req)
    {
        return Student::withCount('courses')
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
        return Student::with('courses')->findOrFail($id);
    }

    public function all()
    {
        return Student::withCount('courses')->get();
    }
}