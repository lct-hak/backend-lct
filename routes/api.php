<?php

use Illuminate\Http\Request;
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

Route::get('/documentation', [\App\Http\Controllers\Documentation\DocumentationController::class, 'index']);

Route::post('/check_no_auth_user', [\App\Http\Controllers\UsersModule\UnautheticateUserController::class, 'getOrCreate']);

Route::post('/create_test', [\App\Http\Controllers\TestModule\AdminController::class, 'createTest']);

Route::post('/access_test', [\App\Http\Controllers\TestModule\TestResponseController::class, 'store']);

Route::get('/get_test', [\App\Http\Controllers\TestModule\TestController::class, 'getTest']);
