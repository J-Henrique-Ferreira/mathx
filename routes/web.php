<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
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

Route::get(uri: '/',action: [MainController::class,'home'])->name('home');
Route::post(uri: '/generate-exercise', action: [MainController::class,'generateExercise'])->name('generateExercises');
Route::get(uri: '/print-exercises', action: [MainController::class,'printExercises'])->name('printExercises');
Route::get(uri: '/export-exercises', action: [MainController::class,'exportExercises'])->name('exportExercises');
