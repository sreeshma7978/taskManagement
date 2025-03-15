<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Task\TaskController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tasks', [TaskController::class, 'addTask']);
    Route::get('/tasks', [TaskController::class, 'getAllTasks']);
    Route::put('/tasks/{id}/assign', [TaskController::class, 'assignTask']);
    Route::put('/tasks/{id}/complete', [TaskController::class, 'markAsComplete']);

});
