<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ResearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --------------------------------<Authentication Routes>--------------------------------
Route::controller(AuthController::class)->group(function(){

    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

// --------------------------------<Graduation Projects Routes>--------------------------------
Route::controller(ProjectController::class)->middleware('auth:sanctum')
    ->group(function(){
    Route::get('/show_GP', 'show_GP');
    Route::post('/submit_GP', 'submit_GP');
    Route::get('/get_GP', 'get_GP');
    Route::get('/search_GP', 'search_GP');

    });

// --------------------------------<Books Routes>--------------------------------
Route::controller(BookController::class)
    ->group(function(){
        Route::get('/get_books', 'get_books');
        Route::get('/search_books', 'search_books');
    });

// --------------------------------<Research Routes>--------------------------------
Route::controller(ResearchController::class)
    ->group(function(){
        Route::get('/get_research', 'get_research');
        Route::get('/search_research', 'search_research');
    });
