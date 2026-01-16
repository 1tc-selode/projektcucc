<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalCourses = Course::count();
        $activeCourses = Course::where('status', 'active')->count();
        $completedCourses = Course::where('status', 'completed')->count();
        $plannedCourses = Course::where('status', 'planned')->count();

        return response()->json([
            'total_courses' => $totalCourses,
            'active_courses' => $activeCourses,
            'completed_courses' => $completedCourses,
            'planned_courses' => $plannedCourses,
            'statistics' => [
                'total' => $totalCourses,
                'by_status' => [
                    'active' => $activeCourses,
                    'completed' => $completedCourses,
                    'planned' => $plannedCourses
                ]
            ]
        ]);
    }
}
