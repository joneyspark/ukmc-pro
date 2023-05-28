<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Application\ApplicationController;


Route::controller(ApplicationController::class)->group(function () {
    Route::get('application-create', 'create');
    Route::get('all-application', 'all');
    Route::get('ongoing-applications', 'ongoing');
    Route::get('enrolled-students', 'enrolled');
    Route::get('archive-students', 'archive_students');
    Route::get('application-details', 'application_details');
});
