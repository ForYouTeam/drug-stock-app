<?php

use App\Http\Controllers\Admin\DrugController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\StaffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/drug')->controller(DrugController::class)->group(function() {
    Route::get('/', 'getAllData');
    Route::get('/{id}', 'getDataById');
    Route::post('/', 'upsertData');
    Route::delete('/{id}', 'deleteData');
});

Route::prefix('v1/warehouse')->controller(WarehouseController::class)->group(function() {
    Route::get('/', 'getAllData');
    Route::get('/{id}', 'getDataById');
    Route::post('/', 'upsertData');
    Route::delete('/{id}', 'deleteData');
});

Route::prefix('v1/staff')->controller(StaffController::class)->group(function() {
    Route::get('/', 'getAllData');
    Route::get('/{id}', 'getDataById');
    Route::post('/', 'upsertData');
    Route::delete('/{id}', 'deleteData');
});
