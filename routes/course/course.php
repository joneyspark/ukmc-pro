<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CourseCategoryController;


Route::controller(CourseController::class)->group(function () {
    Route::get('course-create', 'create');
    Route::get('all-course', 'all');
    Route::get('archived-courses', 'archive');
    Route::get('course-details/{slug?}', 'course_details');
});
Route::controller(CourseCategoryController::class)->group(function () {
    Route::get('course-categories/{id?}', 'course_categories');
    Route::post('course-category-store', 'store');
    Route::post('category-status-change', 'category_status_change');

    Route::get('course-levels/{id?}', 'course_levels');
    Route::post('course-level-store', 'level_store');
    Route::post('level-status-change', 'level_status_change');

});
