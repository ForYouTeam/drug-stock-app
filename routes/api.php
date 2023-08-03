<?php

use App\Http\Controllers\Admin\DrugController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/drug')->controller(DrugController::class)->group(function() {
    Route::get('/', 'getAllData');
    Route::get('/{id}', 'getDataById');
    Route::post('/', 'upsertData');
    Route::delete('/{id}', 'deleteData');
});
