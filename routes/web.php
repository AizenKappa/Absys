<?php

use App\Http\Controllers\AbsysController;
use App\Http\Controllers\SessionController;
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

Route::get('/',[SessionController::class,'create'])->middleware('guest');
Route::post('/login',[SessionController::class,'store']);
Route::get('/logout',[SessionController::class,'destroy']);

Route::view('/user_info','user_info')->middleware('guest');
Route::post('/check_user',[SessionController::class,'check']);

Route::view('/pwd_reset','pwd_reset')->middleware('guest');
Route::post('/pwd_reset',[SessionController::class,'reset']);

Route::get('/home',[AbsysController::class,'index'])->middleware('auth');
