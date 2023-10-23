<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/users', [UserController::class, 'create'])->name('create');
Route::get('/users/{id}', [UserController::class, 'getId'])->name('getById');
Route::get('/users', [UserController::class, 'getAll'])->name('getAll');
