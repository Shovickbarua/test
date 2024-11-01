<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/all', [CourseController::class, 'allCourses'])->name('courses.all');
Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
