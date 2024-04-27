<?php
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminProjectController;
use Illuminate\Support\Facades\Route;


// --------------------------------<Authentication Routes>--------------------------------
Route::controller(AdminAuthController::class)->group(function(){
    Route::post('/admin/login', 'login');
    Route::post('/admin/logout', 'logout')->middleware('auth:sanctum');

});
//-----------------------------------<Projects Routes>---------------------------------------
Route::controller(AdminProjectController::class)->middleware('auth:admin')->group(function (){
    Route::post('/admin/upload_project', 'upload_project');
    Route::get('/admin/get_all_projects', 'get_all_projects');
    Route::get('/admin/search_GP', 'search_GP');

    Route::get('/admin/get_project/{project_id}', 'get_project');
    Route::post('/admin/update_project/{project_id}', 'update_project');
    Route::post('/admin/delete_project/{project_id}', 'delete_project');
    Route::post('/admin/accept_project/{project_id}', 'accept_project');
    Route::post('/admin/reject_project/{project_id}', 'reject_project');
    Route::get('/admin/get_accepted_projects', 'get_accepted_projects');
    Route::get('/admin/get_rejected_projects', 'get_rejected_projects');
    Route::get('/admin/get_pending_projects', 'get_pending_projects');


});
//-----------------------------------<Books Routes>---------------------------------------
Route::controller(AdminBookController::class)->middleware('auth:admin')->group(function () {
    Route::post('/admin/upload_book', 'upload_book');
    Route::post('/admin/update_book/{book_id}', 'update_book');
    Route::post('/admin/delete_book/{book_id}', 'delete_book');
    Route::get('/admin/get_all_books', 'get_all_books');
    Route::get('/admin/search_book', 'search_book');
    Route::get('/admin/show_book/{book_id}', 'show_book');


});
