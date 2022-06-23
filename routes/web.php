<?php

use App\Http\Controllers\AbsysController;
use App\Http\Controllers\Api\FiliereController;
use App\Http\Controllers\SessionController;
use App\Http\Resources\FiliereResource;
use App\Models\Etat;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManagerStatic as Image;

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
Route::view('/add','home')->middleware('auth');
Route::view('/detail','home')->middleware('auth');
Route::view('/Profile','home')->middleware('auth');
Route::view('/stagiaire/{id}',"home")->middleware('auth');
Route::view('/User',"home")->middleware('auth');
Route::view('/addUser',"home")->middleware('auth');

Route::get('/user', [FiliereController::class, 'getuser']);
Route::get('/user/{id}', [FiliereController::class, 'deletuser']);

Route::post('/profile', [FiliereController::class, 'getprofile']);
Route::get('/deletPicture', [FiliereController::class, 'deletPicture']);
Route::post('/addNewUser', [FiliereController::class, 'addUser']);
Route::get('/users', [FiliereController::class, 'getusers']);

Route::get('/updateStatus', function (){


    if(Auth::check()){
        $user = User::Find(Auth::user()->id);
        $user->status = 1;
        $user->save();
    }


});






// Route::get('/test',function(){
//     $filtered = Etat::with('stagiaire.groupe')->get()->filter(function($value){

//             return $value->toArray()['stagiaire']['groupe']['filiere_id'] == 1;
//     });
//     dump($filtered->all());
// });