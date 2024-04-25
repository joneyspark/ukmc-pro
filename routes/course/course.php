<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CourseCategoryController;
use App\Http\Controllers\Course\GroupController;

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
    Route::post('schedule-status-change','schedule_status_change');
    Route::get('subject/schedule-details/{id?}','schedule_details');
    Route::get('subject/class/student/attendence/{id?}/confirm','attendence_details');
    Route::post('class/schedule/attendence-confirmation','attendence_confirmation');
    Route::get('subject/attendance/{id?}','attendance');
    Route::get('attendance-report','attendance_report');
    Route::get('get-intake-list/{id?}','get_intake_list');
    Route::post('transfer-subject-from-another-intake','transfer_subject_from_another_intake');
    Route::post('class/schedule/present-call','present_call');
    Route::post('class/schedule/absent-call','absent_call');
    Route::post('class/schedule/leave-call','leave_call');
    Route::get('class/schedule/get-notes/{id?}','get_notes');
    Route::get('class/schedule/note_delete/{id?}/{schedule_id?}','main_note_delete');
    Route::get('class/schedule/quick-attendence','quick_attendence');
    Route::get('reset-schedule-list','reset_schedule_list');
    Route::post('class/schedule/schedule-note-post','application_note_post');
    Route::get('subject/schedule/{id?}/{edit?}/{schedule_id?}', 'course_subject_schedule');
    Route::post('course/subject/subject-schedule-data-post','subject_schedule_data_post');

});
Route::controller(CourseCategoryController::class)->group(function () {
    Route::get('course-categories/{id?}', 'course_categories');
    Route::post('course-category-store', 'store');
    Route::post('category-status-change', 'category_status_change');

    Route::get('course-levels/{id?}', 'course_levels');
    Route::post('course-level-store', 'level_store');
    Route::post('level-status-change', 'level_status_change');

});
Route::controller(GroupController::class)->group(function () {
    Route::get('create-course-group/{id?}/{edit?}/{group_id?}','create_course_group');
    Route::get('course-intake-group-list/{id?}','course_intake_group_list');
    Route::post('course/group-data-post','group_data_post');
    Route::post('course/group-status-change','group_status_change');
    Route::post('join-to-group','join_group');
    Route::get('attendence-groups','attendence_groups');
    Route::get('get-intake-data/{id?}','get_intake_data');
    Route::post('group-data-status-change','group_data_status_change');
    Route::get('attendence-group-details/{id?}','attendence_group_details');
    Route::get('make-class-schedules','make_class_schedules');
    Route::post('group-is-done-status-change','group_is_done_status_change');
    Route::get('group-attendence/{id?}','group_attendence');
    Route::get('get-application-by-group/{id?}','get_application_by_group');
    Route::post('move-to-another-group','move_to_another_group');
    Route::post('create-authorised-absent','create_authorised_absent');
    Route::get('get-attend-list-of-student/{id?}','get_attend_list_of_student');
    Route::post('authorised-absent-status-change','authorised_absent_status_change');
});
