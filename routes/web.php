<?php

use App\Http\Controllers\StudentController;
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



Route::get('/student', [StudentController::class,'index']);
Route::post('/student', [StudentController::class,'store']);

Route::get('/display', [StudentController::class,'display']);
Route::get('/edit_student/{id}', [StudentController::class,'edit']);
Route::put('/update_student/{id}', [StudentController::class,'update']);
Route::delete('/destroy_student/{id}', [StudentController::class,'destroy']);
