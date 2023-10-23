<?php

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

Route::view('/users', 'usersList')->name('users');
Route::view('/', 'usersList');
Route::view('/users/create', 'createUser')->name('createPage');
Route::view('/users/{id}', 'userData')->name('userData');
