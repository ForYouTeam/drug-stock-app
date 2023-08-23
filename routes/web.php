<?php

use App\Http\Controllers\Admin\DrugController;
use App\Http\Controllers\Admin\ReceiverController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
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

  
Route::get('/'            , [DashboardController   ::class, 'index'])->middleware(['auth' ])->name('dashboard'   );
Route::get('/drugs'       , [DrugController        ::class, 'index'])->middleware(['auth', 'role:super-admin|admin' ])->name('drugs'       );
Route::get('/warehouses'  , [WarehouseController   ::class, 'index'])->middleware(['auth', 'role:super-admin|admin' ])->name('warehouse'   );
Route::get('/staff'       , [StaffController       ::class, 'index'])->middleware(['auth', 'role:super-admin|admin' ])->name('staff'       );
Route::get('/transaction' , [TransactionController ::class, 'index'])->middleware(['auth', 'role:super-admin|admin' ])->name('transaction' );
Route::get('/transaction/export' , [TransactionController ::class, 'export'])->middleware(['auth', 'role:super-admin|admin' ])->name('transaction-export' );
Route::get('/receiver'    , [ReceiverController    ::class, 'index'])->middleware(['auth', 'role:super-admin|admin' ])->name('receiver'    );
Route::get('/akun'        , [UserController        ::class, 'index'])->middleware(['auth', 'role:super-admin'       ])->name('akun'    );


Route::get('/auth', [AuthController::class, 'index'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/auth/process', [AuthController::class, 'login'])->name('login.process');
