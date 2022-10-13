<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

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

// authentication
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('checkRole:1')->group(function () {
    Route::get('/dashboardAdmin', [DashboardController::class, 'index'])->name('dashboardAdmin');
});

Route::middleware('checkRole:2')->group(function () {
    Route::get('/dashboardPengajar', [DashboardController::class, 'index'])->name('dashboardPengajar');
});
