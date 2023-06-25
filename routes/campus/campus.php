<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Campus\CampusController;


Route::controller(CampusController::class)->group(function () {
    Route::get('campus-create', 'create');
    Route::post('store-campus-data', 'store');
    Route::get('all-campus', 'all');
    Route::get('archived-campus', 'archive');
    Route::get('edit-campus/{slug?}', 'edit');
    Route::post('campus-edit-data-post', 'edit_data_post');
    Route::get('view-campus/{slug?}', 'view_campus');
    Route::get('delete-campus/{id?}', 'delete_campus');
    Route::post('campus-change-status', 'change_status');

    Route::post('university-store', 'university_store');
    Route::post('university-status-change', 'university_status_change');
    Route::get('universities/{id?}', 'universities');
});
