<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// --------------------------------<Authentication Routes>--------------------------------
Route::controller(AuthController::class)->group(function(){

    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
    
});

// --------------------------------<Graduation Projects Routes>--------------------------------
Route::controller(ProjectController::class)->middleware('auth:sanctum')
    ->group(function(){
    Route::get('/show_GP', 'show');
    Route::post('/submit_GP', 'submit');
    Route::get('/get_GP', 'get_GP');
    Route::get('/search_GP', 'search_GP');

    });
// --------------------------------<Exams Routes>--------------------------------
Route::get('exam-photos', 'ExamPhotoController@show');