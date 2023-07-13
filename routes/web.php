<?php

use Illuminate\Support\Facades\Route;
use App\Events\AddNewLead;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Agent\AgentTaskController;


Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('login', 'login');
    Route::get('student-login', 'student_login');
    Route::get('student-register', 'student_register');
    Route::post('student-register-post', 'student_register_post');
    Route::get('get-notification-count', 'get_notification_count');
    Route::get('get-my-notification', 'get_my_notification');
    Route::get('my-notification-list', 'get_all_my_notification');
    Route::get('show-all-activity', 'show_all_activity');
});
Route::controller(TaskController::class)->group(function () {
    Route::get('task-create', 'create');
    Route::post('task-store', 'store');
    Route::get('task-list', 'all');
    Route::get('my-tasks', 'my_tasks');
    Route::get('edit-task/{slug?}', 'edit');
    Route::post('edit-task-post', 'edit_post');
    Route::get('task/details/{slug?}','details');
    Route::post('task-coment-store', 'task_commment');
    Route::post('task-status-chnage', 'task_status_chnage');
});
Route::controller(AgentTaskController::class)->group(function () {
    Route::get('agent-task-create', 'create');
    Route::post('agent-task-store', 'store');
    Route::get('agent-task-list', 'all');
    Route::get('agent-my-tasks', 'my_tasks');
    Route::get('agent-edit-task/{slug?}', 'edit');
    Route::post('agent-edit-task-post', 'edit_post');
    Route::get('agent/task/details/{slug?}','details');
    Route::post('agent-task-coment-store', 'task_commment');
    Route::post('agent-task-status-chnage', 'task_status_chnage');
});
Route::controller(SettingController::class)->group(function () {
    Route::get('company-settings', 'company_settings');
    Route::post('company-setting-post', 'company_setting_post');

});

Route::controller(LoginController::class)->group(function () {
    Route::post('user-login-post', 'user_login');
    Route::get('sign-out', 'sign_out');
    Route::get('reset-password', 'reset_password');
    Route::post('reset-password-post', 'reset_password_post');
    Route::get('reset-password-form/{token?}', 'reset_password_form');
    Route::post('reset-password-form-post', 'reset_password_form_post');
});

Route::get('test', function () {
    AddNewLead::dispatch('Hello this is test');
    //event(new AddNewLead('hello world'));
    return "Event has been sent!";
});

Route::controller(UserController::class)->group(function () {
    Route::get('user-list', 'user_list');
    Route::get('create-teacher', 'create_teacher');
    Route::get('create-manager', 'create_manager');
    Route::get('edit-manager/{slug?}', 'edit_manager');
    Route::post('edit-manager-data-post', 'edit_manager_data_post');
    Route::post('create-manager-post-data', 'create_manager_post_data');
    Route::get('create-admission-manager', 'create_admission_manager');
    Route::post('create-admission-manager-post-data', 'create_admission_manager_post_data');
    Route::post('create-teacher-post-data', 'create_teacher_post_data');
    Route::post('user-status-chnage', 'user_status_chnage');
    Route::get('reset-user-list', 'reset_user_list')->name('reset_user_list');
    Route::post('user-role-confirm', 'user_role_confirm');
    Route::get('edit-teacher/{slug?}', 'edit_teacher');
    Route::get('edit-admission-manager/{slug?}', 'edit_admission_manager');
    Route::post('edit-teacher-data-post', 'edit_teacher_data_post');
    Route::post('edit-officer-data-post', 'edit_officer_data_post');
    Route::get('profile-settings', 'profile_settings');
    Route::get('edit_profile', 'edit_profile');
    Route::post('my-profile-update', 'my_profile_update');
    Route::get('my-team-list', 'my_team_list');
    Route::get('get-assign-to-user/{id?}', 'get_assign_to_user');
    Route::post('transfer_assign_to_user', 'transfer_assign_to_user');
    Route::post('confirm_transfer_application_to_interviewer', 'confirm_transfer_application_to_interviewer');
    Route::post('confirm_transfer_application_to_admission_officer', 'confirm_transfer_application_to_admission_officer');
    Route::get('get-admission-officer-by-manager','get_admission_officer_by_manager');
    Route::get('create-admission-manager-by-manager', 'create_admission_manager_by_manager');
    Route::post('create-admission-manager-by-manager-post', 'create_admission_manager_by_manager_post');
    Route::get('edit-admission-manager-by-manager/{slug?}', 'edit_admission_manager_by_manager');
    Route::post('edit-admission-manager-by-manager-post', 'edit_admission_manager_by_manager_post');

    Route::get('student-list', 'student_list');
    Route::get('reset-student-list', 'reset_student_list')->name('reset-student-list');

    Route::get('create-interviewer','create_interviewer');
    Route::post('create-interviewer-data-post','create_interviewer_data_post');
    Route::get('edit-interviewer/{slug}','edit_interviewer');
    Route::post('edit-interviewer-data-post','edit_interviewer_data_post');

    Route::get('get-interviewer-application/{id?}','get_interviewer_application');
    Route::get('reset-interviewer-application-search-list','reset_interviewer_application_search_list');
    Route::post('application_assign_to_other_interviewer','application_assign_to_other_interviewer');
    Route::get('get-admission-officer-application/{id?}','get_admission_officer_application');

    Route::post('application_assign_to_manager_by_admin','application_assign_to_manager_by_admin');
});
