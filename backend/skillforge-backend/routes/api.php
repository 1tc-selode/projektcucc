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

// Student operations (index, store, destroy only)
Route::apiResource('students', StudentController::class)->only(['index','store','destroy']);

// Instructor operations (index, store only)
Route::apiResource('instructors', InstructorController::class)->only(['index','store']);

// Contact messages
Route::get('contact', [ContactController::class,'index']);
Route::post('contact', [ContactController::class,'store']);
