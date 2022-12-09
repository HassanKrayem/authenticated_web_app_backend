<?php

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

Route::post('/user/authenticate', [\App\Http\Controllers\UserController::class, 'authenticate']);
Route::get('/company', [\App\Http\Controllers\CompanyController::class, 'index']);
Route::get('/company/search', [\App\Http\Controllers\CompanyController::class, 'search']);
