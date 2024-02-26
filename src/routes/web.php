<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\ProfileController;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::permanentRedirect('/', RouteServiceProvider::HOME);

    Route::get('/login', [LoginController::class, 'showLoginPage'])->name('auth.login');
    Route::get('/logout', [LoginController::class, 'logout'])->name('auth.logout');

    Route::get('/', static function () {
        return view('home');
    })->name('home');

    Route::post('/processRegister', [LoginController::class, 'register'])->name('register');
    Route::post('/processLogin', [LoginController::class, 'login'])->name('login');

    Route::get('/monitoringForm', static function () {
        return view('monitoring-form');
    })->name('monitoringForm');

    Route::post('/monitoringAccess', [AssessmentController::class, 'showMonitorPage'])->name('showMonitorPage');
    Route::post('/monitor', [AssessmentController::class, 'processCameraAccess'])->name('processCameraAccess');
    Route::get('/results', [AssessmentController::class, 'monitorResults'])->name('monitorResults');

    Route::get('/profile', [ProfileController::class, 'showProfilePage'])->name('profilePage');
    Route::get('/profile/edit', [ProfileController::class, 'showProfileEditPage'])->name('profileEditPage');
    Route::post('/processProfileEdit', [ProfileController::class, 'editProfile'])->name('editProfile');
    Route::get('/profile/{id}/delete', [ProfileController::class, 'deleteAccount'])->name('deleteAccount');
    Route::post('/avatar/delete', [ProfileController::class, 'deleteAvatar'])->name('deleteAvatar');

    Route::get('/monitoring', [MonitoringController::class, 'showMonitorPage'])->name('monitorPage');
//    Route::post('/monitor', [AssessmentController::class, 'processCameraAccess'])->name('processCameraAccess');
});


//TODO: ссылки на источники
