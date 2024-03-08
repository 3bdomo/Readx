<?php

use App\Helpers\ApiResponse;
use App\Http\Controllers\AdminController;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $p=User::where('project_id','=',8)->first();
    if($p==null){
        return 'null';
    }

   // return view('welcome');

});

Route::get('/admin/login',[AdminController::class,'loginForm'])
    ->name('admin.loginForm');

Route::post('/admin/login',[AdminController::class,'login'])
    ->name('admin.login');

Route::post('/admin/logout',[AdminController::class,'logout'])
    ->name('admin.logout')
    ->middleware('auth:admin');
