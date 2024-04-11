<?php

// --------------------------------<Authentication Routes>--------------------------------
use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AdminAuthController::class)->group(function(){


    Route::post('/admin/login', 'login');
    Route::post('/admin/logout', 'logout')->middleware('auth:sanctum');

});
