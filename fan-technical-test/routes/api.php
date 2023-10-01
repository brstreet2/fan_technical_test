<?php

use App\Http\Controllers\Api\Attendance\AttendanceController;
use App\Http\Controllers\Api\Authentication\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication
Route::post('/login', [AuthenticationController::class, "login"])->name('api.login');
Route::get('/logout', [AuthenticationController::class, "logout"])->name('api.logout');

// Absensi
Route::post('/absen', [AttendanceController::class, 'insertData'])->name('api.insert');
Route::post('/approve', [AttendanceController::class, 'approveData'])->name('api.approve');
Route::get('/data', [AttendanceController::class, 'getData'])->name('api.get');
