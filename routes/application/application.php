<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Application\ApplicationController;
use App\Http\Controllers\Application\ApplicationOtherController;


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
    Route::post('step-2-post', 'step_2_post');
    Route::post('step-3-post', 'step_3_post');
    Route::post('step-4-post', 'step_4_post');
    Route::post('step-5-post', 'step_5_post');
    Route::post('step-6-post', 'step_6_post');
    Route::get('agent-applications', 'agent_applications');
    Route::get('agent-applications/{id?}/details', 'agent_application_details');
    Route::get('application/{id?}/details', 'application_details_by_admin');
    Route::post('application/assign-to-me', 'application_assign_to_me');
    Route::post('request-document-message', 'request_document_message');
    Route::get('confirm-request-document/{id?}', 'confirm_request_document');
    Route::get('application/{id?}/processing', 'application_processing');
    Route::get('pending-applications', 'pending_applications');
    Route::get('interview-list', 'interview_list');
});

Route::controller(ApplicationOtherController::class)->group(function () {
    Route::get('application-get-notes/{id?}', 'get_notes');
    Route::post('application-note-post', 'application_note_post');
    Route::get('application-get-followups/{id?}', 'get_followups');
    Route::post('follow-up-note-post', 'follow_up_note_post');

    Route::get('application-get-meetings/{id?}', 'get_meetings');
    Route::get('meeting-note-remove/{id?}', 'meeting_note_remove');
    Route::post('application-meeting-note-post', 'meeting_note_post');
    Route::get('follow-up-note-remove/{id?}', 'follow_up_note_delete');
    Route::get('main-note-remove/{id?}', 'main_note_delete');

    Route::post('note-create-of-application-details', 'note_create_of_application_details');
});
