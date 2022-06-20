<?php

use App\Http\Controllers\AbsysController;
use App\Http\Controllers\Api\FiliereController;
use App\Http\Controllers\SessionController;
use App\Http\Resources\FiliereResource;
use App\Models\Etat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

Route::view('/user_info','login.user_info')->middleware('guest');
Route::post('/check_user',[SessionController::class,'check']);

Route::view('/pwd_reset','login.pwd_reset')->middleware("isvalidreset");
Route::post('/pwd_reset',[SessionController::class,'reset']);

Route::get('/home',[AbsysController::class,'index'])->middleware('auth');
Route::view('/just','home')->middleware('auth');
Route::view('/detail','home')->middleware('auth');
Route::view('/Profile','home')->middleware('auth');

Route::get('/user', [FiliereController::class, 'getuser']);


// Route::get('/test',function(){
//     $filtered = Etat::with('stagiaire.groupe')->get()->filter(function($value){

//             return $value->toArray()['stagiaire']['groupe']['filiere_id'] == 1;
//     });
//     dump($filtered->all());
// });