<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ResearchController;
use Illuminate\Support\Facades\Route;

// --------------------------------<Authentication Routes>--------------------------------
Route::controller(UserAuthController::class)->group(function(){

    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');

});
// --------------------------------<Graduation Projects Routes>--------------------------------
Route::middleware('auth:sanctum')->controller(ProjectController::class)
    ->group(function(){
    Route::get('/show_GP', 'show_GP');
    Route::post('/submit_GP', 'submit_GP');
    Route::get('/get_GP', 'get_GP');
    Route::get('/search_GP', 'search_GP');
    Route::post('/check_plagiarism', 'check_plagiarism');
    Route::post('/add_team_members', 'add_team_members');

    });


// --------------------------------<Books Routes>--------------------------------
Route::controller(BookController::class)->middleware('auth:sanctum')
    ->group(function(){
        Route::get('/get_books', 'get_books');
        Route::get('/search_books', 'search_books');
        Route::post('/rate_a_book','rate_a_book');
    });

// --------------------------------<Research Routes>--------------------------------
Route::controller(ResearchController::class)->middleware('auth:sanctum')
    ->group(function(){
        Route::get('/get_research', 'get_research');
        Route::get('/search_research', 'search_research');
    });

// --------------------------------<Exams Routes>--------------------------------
Route::middleware('auth:sanctum')->controller(ExamController::class)
    ->group(function(){
        Route::get('/show_exams', 'show_exams');
        Route::get('/search_exam','search_exam');
    });


require __DIR__.'/AdminRoutes.php';
