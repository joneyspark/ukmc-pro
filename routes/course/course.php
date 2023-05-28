<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Course\CourseController;


Route::controller(CourseController::class)->group(function () {
    Route::get('course-create', 'create');
    Route::get('all-course', 'all');
    Route::get('archived-courses', 'archive');
    Route::get('course-categories', 'course_categories');
    Route::get('course-levels', 'course_levels');
    Route::get('course-details/{slug?}', 'course_details');
});
