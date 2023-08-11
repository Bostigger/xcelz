<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\News\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Auth routes
Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'Login']);
    Route::post('/register', [AuthController::class, 'Register']);
});

// News and Articles routes
Route::prefix('news')->group(function() {
    Route::get('/', [NewsController::class, 'fetchAndSaveArticles']);
    Route::get('/articles', [NewsController::class, 'getAllArticles']);
    Route::post('/articles/search', [NewsController::class, 'search']);
    Route::post('/articles/find', [NewsController::class, 'findArticle']);
    Route::get('/articles/{id}', [NewsController::class, 'fetchArticles']);
    Route::get('/category', [NewsController::class, 'getCategory']);
    Route::get('/author', [NewsController::class, 'getAuthor']);
    Route::get('/source', [NewsController::class, 'getSource']);
});

// User routes
Route::prefix('user')->group(function() {
    Route::post('/preference/{id}', [NewsController::class, 'savePreference']);
});

