<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
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
    return view('welcome');
});
Route::resource('files',FileController::class)->middleware('auth');


Route::get('home',[DashboardController::class,'index'])->name('dashboard.index')->middleware('auth');




Route::get('/show/{id}',[FileController::class,'show'])->name('file.show');

Route::post('/download-file', [FileController::class,'downloadFile'])->name('download.file');




// Auth


Route::get('/register',[RegisterController::class,'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class,'register']);
Route::get('/login', [LoginController::class,'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class,'login']);


Route::post('/logout',[LoginController::class,'logout'])->name('logout');
