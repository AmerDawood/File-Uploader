<?php

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
Route::resource('files',FileController::class);

Route::get('/admin/dashboard',[DashboardController::class,'index'])->name('dashboard.index');

Route::get('/show/{id}',[FileController::class,'show'])->name('file.show');

Route::post('/download-file', [FileController::class,'downloadFile'])->name('download.file');
