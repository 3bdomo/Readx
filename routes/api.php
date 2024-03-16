<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ProjectController;
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

// --------------------------------<Graduation Projects Routes>--------------------------------
Route::controller(BookController::class)->middleware('auth:sanctum')
    ->group(function(){
        Route::get('/show_book', 'show_book');
        Route::get('/search_book', 'search_book');

    });
