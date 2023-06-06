<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Application\ApplicationController;


Route::controller(ApplicationController::class)->group(function () {
    Route::get('application-create/{id?}', 'create');
    Route::get('application-create/{id?}/step-2', 'create_step_2');
    Route::get('application-create/{id?}/step-3', 'create_step_3');
    Route::get('application-create/{id?}/step-4', 'create_step_4');
    Route::get('application-create/{id?}/step-5', 'create_step_5');
    Route::get('application-create/{id?}/step-6', 'create_step_6');
    Route::get('all-application', 'all');
    Route::get('ongoing-applications', 'ongoing');
    Route::get('enrolled-students', 'enrolled');
    Route::get('archive-students', 'archive_students');
    Route::get('application-details', 'application_details');
    Route::post('get-courses-by-campus', 'get_courses_by_campus');
    Route::post('get-course-info', 'get_course_info');
    Route::post('step-1-post', 'step_1_post');
});
