<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::controller(PageController::class)->group(function () {
        Route::get('/users', 'userManagement')->name('administration.users.index')->middleware(['password.confirm']);
        Route::get('/role-management', 'roleManagement')->name('administration.roles.index')->middleware('password.confirm');
        Route::get('/file-management', 'fileMangement')->name('file_management');
    });

});

require __DIR__.'/auth.php';

// MediaManager
ctf0\MediaManager\MediaRoutes::routes();