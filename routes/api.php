<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
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


Route::any('auth/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    // User
    Route::get('user', [UserController::class, 'getUser']);

    // Complaint
    Route::post('complaint', [ComplaintController::class, 'addComplaint']);
    Route::get('complaints', [ComplaintController::class, 'list']);
    Route::delete('complaint', [ComplaintController::class, 'delete']);

    // Post
    Route::post('post', [PostController::class, 'addPost']);
    Route::get('posts', [PostController::class, 'list']);
    Route::delete('post/{id}', [PostController::class, 'delete']);

    // Report
    Route::post('report', [ReportController::class, 'addReport']);
    Route::get('reports', [ReportController::class, 'list']);
    Route::delete('report/{id}', [ReportController::class, 'delete']);

    Route::middleware('ability:role-admin')->prefix('admin')->group(function () {
        Route::get('user/{id}', [UserController::class, 'getUserAdmin']);

        Route::get('complaints', [ComplaintController::class, 'listAdmin']);
        Route::put('complaint', [ComplaintController::class, 'updateAdmin']);

        // Room
        Route::post('room', [RoomController::class, 'addRoom']);
        Route::get('rooms', [RoomController::class, 'list']);
        Route::put('room', [RoomController::class, 'update']);
        Route::get('room/{code}', [RoomController::class, 'get']);
        Route::delete('room/{code}', [RoomController::class, 'addRoom']);
    });
});
