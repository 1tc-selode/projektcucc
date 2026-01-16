<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseRepository
{
    public function paginate(Request $req) {
        return Course::with('instructor')
            ->when($req->search, fn($q) =>
                $q->where('title','like','%'.$req->search.'%')
                  ->orWhere('description','like','%'.$req->search.'%'))
            ->when($req->status, fn($q) =>
                $q->where('status', $req->status))
            ->when($req->difficulty, fn($q) =>
                $q->where('difficulty', $req->difficulty))
            ->orderBy(
                $req->sort ?? 'created_at',
                $req->dir ?? 'desc'
            )
            ->paginate($req->per_page ?? 10);
    }

    public function findById($id)
    {
        return Course::with(['instructor', 'students'])->findOrFail($id);
    }

    public function getByStatus($status)
    {
        return Course::with('instructor')
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getStats()
    {
        return [
            'total' => Course::count(),
            'active' => Course::where('status', 'active')->count(),
            'completed' => Course::where('status', 'completed')->count(),
            'planned' => Course::where('status', 'planned')->count(),
        ];
    }
}
