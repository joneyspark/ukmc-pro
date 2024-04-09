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
    Route::get('sub-agent-applications', 'sub_agent_applications');
    Route::get('reset-sub-agent-application-search', 'reset_sub_agent_application_search');
    Route::get('agent-applications', 'agent_applications');
    Route::get('agent-applications/{id?}/details', 'agent_application_details');
    Route::get('application/{id?}/details', 'application_details_by_admin');
    Route::post('application/assign-to-me', 'application_assign_to_me');
    Route::post('request-document-message', 'request_document_message');
    Route::get('confirm-request-document/{id?}', 'confirm_request_document');
    Route::get('application/{id?}/processing', 'application_processing');
    Route::get('pending-applications', 'pending_applications');
    Route::get('interview-list', 'interview_list');
    Route::post('application-status-change', 'application_status_change');
    Route::get('reset-application-search', 'reset_application_search');
    Route::get('application/{id?}/details', 'main_application_details');
    Route::get('meeting/{id?}/details', 'meeting_details');
    Route::post('meeting-video-post', 'meeting_video_post');
    Route::get('student-portal', 'student_portal');
    Route::post('get-academic-data', 'get_academic_data');
    Route::get('reset-agent-application-search', 'reset_agent_application_search');
    Route::post('application-assign-to-manager', 'application_assign_to_manager');
    Route::get('get-admission-officer-by-manager/{id?}', 'get_admission_officer_by_manager');

    Route::get('application-step1-new/{id?}', 'application_step1_new');
    Route::post('application-step1-post', 'application_step1_post');
    Route::get('application-step2-new/{id?}', 'step2_new');
    Route::post('get-campus-by-university', 'get_campus_by_university');
    Route::post('qualification-post', 'qualification_post');
    Route::post('experience-post', 'experience_post');
    Route::post('application-assign-to', 'application_assign_to');
    Route::get('my-applications', 'my_applications');
    Route::get('reset-my-application-search', 'reset_my_application_search');

    Route::get('my-assigned-applications', 'my_assigned_applications');
    Route::get('reset-my-assigned-application-search', 'reset_my_assigned_application_search');
    Route::get('interviewer-applications', 'interviewer_applications');
    Route::get('reset-interviewer-application-search', 'reset_interviewer_application_search');
    Route::post('application_assign_to_interviewer', 'application_assign_to_interviewer');
    Route::post('interview-status-change', 'interview_status_change');
    Route::post('make_application_note_by_agent', 'make_application_note_by_agent');
    Route::get('incomplete-applications', 'incomplete_applications');
    Route::get('reset-incomplete-applications', 'reset_incomplete_applications');
    Route::post('meeting-document-upload', 'meeting_document_upload');
    Route::get('meeting-document-delete/{id?}', 'meeting_document_delete');
    Route::get('delete-application/{id?}','delete_application');
    Route::get('delete-application-document/{id?}','delete_application_document');
    Route::post('sop-data-post','sop_data_post');
    Route::get('sop-plagiarism-check/{id?}','sop_plagiarism_check');
    Route::get('sop-plagiarism-check-from-processing/{id?}','sop_plagiarism_check_from_processing');
    Route::get('reset-enrolled-application-search','reset_enrolled_application_search');
    Route::post('transfer-application-to-another-sub-agent','transfer_application_to_another_sub_agent');
    Route::get('unconditional-offer-invite/{id?}','unconditional_offer_invite');
    Route::get('offer-accepted/{id?}','offer_accepted');
    Route::post('submit-decline-offer','submit_decline_offer');
    Route::post('submit-defer-offer','submit_defer_offer');
    Route::post('document-upload-from-web','document_upload_from_web');
    Route::get('offer-request-list','offer_request_list');
    Route::get('transfer-course-to-other','transfer_course_to_other');
    Route::get('get-notification-data-for-activity-list/{id?}','get_notification_data_for_activity_list');
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
    Route::get('meeting-status-change/{id?}', 'meeting_status_change');
    Route::get('followup-status-change/{id?}', 'followup_status_change');
    Route::get('direct-meeting-status-change/{id?}', 'direct_meeting_status_change');
    Route::get('direct-followup-status-change/{id?}', 'direct_followup_status_change');

    Route::get('all-application-status/{id?}', 'all_application_status');
    Route::post('application-status-store', 'application_status_store');
    Route::post('application-main-status-change', 'application_main_status_change');

    Route::get('all-interview-status/{id?}', 'all_interview_status');
    Route::post('interview-status-store', 'interview_status_store');
    Route::post('interview-main-status-change', 'interview_main_status_change');
    Route::post('application-intake-store', 'application_intake_store');
    Route::post('application-intake-status-change', 'application_intake_status_change');
    Route::get('application-intake-list/{id?}','application_intake_list');
    Route::get('get-notes-by-agent/{id?}','get_notes_by_agent');
    Route::post('agent-application-note-post','agent_application_note_post');
    Route::get('agent-main-note-delete/{id?}','agent_main_note_delete');
});
