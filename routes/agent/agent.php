<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Agent\AgentController;


Route::controller(AgentController::class)->group(function () {
    Route::get('agents', 'agents');
    Route::get('create-agent', 'create_agent');
    Route::get('agent-details', 'agent_details');
    Route::post('create-agent-post-data', 'create_agent_post_data');
    Route::post('company-status-chnage', 'company_status_change');
    Route::get('reset-company-list','reset_company_list');
    Route::get('company/{id?}/edit','edit_company');
    Route::post('company-edit-data-post', 'company_edit_data_post');
    Route::get('get-employees-by-company/{id?}/list','get_employees_by_company');
    Route::get('create-agent-by-super-admin/{id?}/new','create_agent_by_super_admin');
    Route::post('create-agent-by-super-admin-post','create_agent_by_super_admin_post');
    Route::get('edit-agent-by-super-admin/{id?}/edit','edit_agent_by_super_admin');
    Route::post('edit-agent-by-super-admin-post','edit_agent_by_super_admin_post');
    Route::get('get-employee-by-agent','get_employee_by_agent');
    Route::get('create-employee-by-agent/{id?}/new','create_employee_by_agent');
    Route::post('create-employee-by-agent-post','create_employee_by_agent_post');
    Route::get('edit-employee-by-agent/{id?}/edit','edit_employee_by_agent');
    Route::post('edit_employee_by_agent_post','edit_employee_by_agent_post');
});
