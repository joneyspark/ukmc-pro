<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CourseCategoryController;


Route::controller(CourseController::class)->group(function () {
    Route::get('course-create', 'create');
    Route::post('course-data-store', 'store');
    Route::get('all-course', 'all');
    Route::get('archived-courses', 'archive');
    Route::get('course-details/{slug?}', 'course_details');
    Route::get('reset-course-list', 'reset_course_list');
    Route::post('course-status-chnage', 'course_status_chnage');
    Route::get('course/edit/{slug?}', 'edit');
    Route::post('course-edit-post', 'edit_post');
    Route::get('course/intake/{id?}/{edit?}/{intake_id?}','course_intake');
    Route::post('course/intake/data-post','course_intake_post');
    Route::post('course/change-intake-status','change_intake_status');
    Route::get('course/subject','course_subject');
    Route::get('subject/class-schedule','subject_schedule');
    Route::get('subject/attendance','attendance');
    Route::get('attendance-report','attendance_report');
});
Route::controller(CourseCategoryController::class)->group(function () {
    Route::get('course-categories/{id?}', 'course_categories');
    Route::post('course-category-store', 'store');
    Route::post('category-status-change', 'category_status_change');

    Route::get('course-levels/{id?}', 'course_levels');
    Route::post('course-level-store', 'level_store');
    Route::post('level-status-change', 'level_status_change');

});
