<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/posts', [PostController::class, 'createPost']);
    Route::get('/posts', [PostController::class, 'getPosts']);
    
    
    Route::get('/user/posts', [PostController::class, 'getMyPosts']);
    Route::get('/validate-token', [AuthController::class, 'validateToken']);
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

