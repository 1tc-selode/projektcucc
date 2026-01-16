<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Dashboard statistics
Route::get('dashboard/stats', [DashboardController::class, 'stats']);

// Course CRUD operations
Route::apiResource('courses', CourseController::class);

// Course-Student relationship endpoints
Route::post('courses/{course}/students/{student}', [CourseController::class, 'attachStudent']);
Route::delete('courses/{course}/students/{student}', [CourseController::class, 'detachStudent']);

// Student operations (full CRUD)
Route::apiResource('students', StudentController::class);

// Student-Course relationship endpoints
Route::post('students/{student}/courses/{course}', [StudentController::class, 'assignCourse']);
Route::delete('students/{student}/courses/{course}', [StudentController::class, 'unassignCourse']);

// Instructor operations (full CRUD)
Route::apiResource('instructors', InstructorController::class);

// Contact messages
Route::get('contact', [ContactController::class,'index']);
Route::post('contact', [ContactController::class,'store']);
