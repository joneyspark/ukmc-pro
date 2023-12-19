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
    Route::get('course/subject/{id?}/{edit?}/{subject_id?}','course_subject');
    Route::post('course/subject/data-post','course_subject_data_post');
    Route::post('course/subject-intake-status','subject_intake_status_change');
    Route::get('subject/class-schedule/{id?}/{edit?}/{schedule_id?}','subject_schedule');
    Route::post('subject-schedule-data-post','subject_schedule_data_post');
    Route::post('schedule-status-change','schedule_status_change');
    Route::get('subject/schedule-details/{id?}','schedule_details');
    Route::get('subject/class/student/attendence/{id?}/confirm','attendence_details');
    Route::post('class/schedule/attendence-confirmation','attendence_confirmation');
    Route::get('subject/attendance','attendance');
    Route::get('attendance-report','attendance_report');
    Route::get('get-intake-list/{id?}','get_intake_list');
    Route::post('transfer-subject-from-another-intake','transfer_subject_from_another_intake');
});
Route::controller(CourseCategoryController::class)->group(function () {
    Route::get('course-categories/{id?}', 'course_categories');
    Route::post('course-category-store', 'store');
    Route::post('category-status-change', 'category_status_change');

    Route::get('course-levels/{id?}', 'course_levels');
    Route::post('course-level-store', 'level_store');
    Route::post('level-status-change', 'level_status_change');

});
