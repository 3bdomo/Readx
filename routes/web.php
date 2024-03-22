<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;


//Route::fallback(function () {
//    return view('welcome');
//});

Route::get('/', function () {
     return view('welcome');

});

//-------------------------------------< Routes for admin auth>----------------------------------.
Route::prefix('admin')->name('admin.')->controller(AdminController::class)->group(function () {

    Route::get('/login', 'loginForm')
        ->name('loginForm')->
        middleware('guest:admin');

    Route::post('/login', 'login')->name('login');

    Route::post('/logout', 'logout')
        ->name('logout')
        ->middleware('auth:admin');

    Route::get('/logout', function (){
        return view('admin.logoutForm');
    })->middleware('auth:admin')
        ->name('get_logout');
  });



//Route::get('/seed',function (){
//
//    \Illuminate\Support\Facades\Artisan::call('storage:link') ;
//    \Illuminate\Support\Facades\Artisan::call('db:seed --force') ;
//   return shell_exec('ls -l ../public');
//});

