<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FullViewController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    Route::get('/jobs', [JobController::class, 'index']);
    Route::get('/jobs/full', [FullViewController::class, 'show']);
    
    Route::get('/community', [CommunityController::class, 'index']);
    Route::get('/community/article', [ArticleController::class, 'show']);
    
    Route::post('/community/post', [CommunityController::class, 'storePost']);
    Route::post('/community/comment', [CommunityController::class, 'storeComment']);
    Route::post('/community/reply', [CommunityController::class, 'storeReply']);
    
    Route::post('/jobs/apply', [JobController::class, 'apply']);
});