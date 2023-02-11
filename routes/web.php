<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\SessionController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login_user')->name('login');
    Route::get('login', 'login_user')->name('login');
    Route::post('login', 'authenticate_user');
    Route::get('logout', 'logout');
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('dashboard', 'data_dashboard');
    Route::get('get-data-dashboard', 'get_data_dashboard');
    Route::get('get-cek-map', 'cek_map');
});

Route::controller(AbsenController::class)->group(function () {
    Route::get('riwayat-kehadiran', 'riwayat_absensi');
});

Route::controller(ScanController::class)->group(function () {
    Route::get('scan-data', 'scan_data');
    Route::post('cari-data', 'cari_data');
    Route::post('proses-clockin', 'clock_in');
    Route::get('proses-clockout', 'clock_out');
    Route::get('cek', 'clock_out');
});

Route::get('/cek-session', [SessionController::class,'cek_session']);