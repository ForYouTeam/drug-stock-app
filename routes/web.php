<?php

use App\Http\Controllers\Admin\DrugController;
use App\Http\Controllers\Admin\ReceiverController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth']], function() {
  
    Route::get('/logout', [AuthController::class, 'perform'])->name('logout.perform');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/drugs', [DrugController::class, 'index'])->name('drugs');
    Route::get('/warehouses', [WarehouseController::class, 'index'])->name('warehouse');
    Route::get('/staff', [StaffController::class, 'index'])->name('staff');
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
    Route::get('/receiver', [ReceiverController::class, 'index'])->name('receiver');
    Route::get('/akun', function () {
        return view('Pages/Acount');
    });
});

Route::get('/auth', [AuthController::class, 'index'])->name('login');
Route::post('/auth/process', [AuthController::class, 'login'])->name('login.process');
