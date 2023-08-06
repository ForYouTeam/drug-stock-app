<?php

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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/auth', [AuthController::class, 'index'])->name('login');

Route::group(['middleware' => ['auth']], function () {
    
});
Route::get('/transaction', function () {
    return view('Pages/Transactions');
});

Route::get('/drugs', function () {
    return view('Pages/Drugs');
});

Route::get('/staff', function () {
    return view('Pages/Staff');
});

Route::get('/werehouse', function () {
    return view('Pages/Wherehouse');
});

Route::get('/akun', function () {
    return view('Pages/Acount');
});
