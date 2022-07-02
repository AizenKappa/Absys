<?php

use App\Http\Controllers\AbsysController;
use App\Http\Controllers\Api\FiliereController;
use App\Http\Controllers\SessionController;
use App\Http\Resources\FiliereResource;
use App\Models\Etat;
use App\Models\Groupe;
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

Route::view('/user_info','login.user_info')->middleware('guest');
Route::view('/pwd_reset','login.pwd_reset')->middleware("isvalidreset");

Route::get('/',[SessionController::class,'create'])->middleware('guest');
Route::post('/login',[SessionController::class,'store']);
Route::get('/logout',[SessionController::class,'destroy']);
Route::post('/check_user',[SessionController::class,'check']);
Route::post('/pwd_reset',[SessionController::class,'reset']);







    /* Definition of Vue routes */
Route::get('/home',function(){
    return view('home');
})->middleware('auth');

Route::get('/just', function(){
    return view('home');
})->middleware('auth');


Route::view('/add','home')->middleware('auth');
Route::view('/detail','home')->middleware('auth');
Route::view('/stagiaire/{id}',"home")->middleware('auth');





    /*!!--Admin section --!!*/
Route::view('/editUser/{id}',"home")->middleware('auth');
Route::view('/Profile','home')->middleware('auth');
Route::view('/User',"home")->middleware('auth');
Route::view('/Estg',"home")->middleware('auth');
Route::view('/addUser',"home")->middleware('auth');
Route::view('/SearchByDate',"home")->middleware('auth');
Route::view('/editEtat',"home")->middleware('auth');
Route::view('/settings',"home")->middleware('auth');




    /* CRUD USER -----> */
Route::post('/profile', [FiliereController::class, 'getprofile'])->middleware('auth');
Route::get('/deletPicture', [FiliereController::class, 'deletPicture'])->middleware('auth');
Route::get('/allUsers', [FiliereController::class, 'index_users'])->middleware('auth');
Route::post('/userById', [FiliereController::class, 'userById'])->middleware('auth');
Route::post('/addNewUser', [FiliereController::class, 'addUser'])->middleware('auth');
Route::post('/editThisUser', [FiliereController::class, 'editThisUser'])->middleware('auth');
Route::post('/updatePwdUser', [FiliereController::class, 'updatePwdUser'])->middleware('auth');
Route::post('updateUser', [FiliereController::class, 'update_user'])->middleware('auth');
Route::get('/allUsers/{id}', [FiliereController::class, 'deletuser'])->middleware('auth');
Route::get('/authUser', [FiliereController::class, 'getAuthUser'])->middleware('auth');
Route::get('/updateStatus', [FiliereController::class, 'updateStatus'])->middleware('auth');
Route::post('/updateStagiaire', [FiliereController::class, 'update_stagiaire'])->middleware('auth');

Route::post('/storeExcel', [FiliereController::class, 'store_excel'])->middleware('auth');

Route::get('/checkTime', [FiliereController::class, 'check_time'])->middleware('auth');
Route::get('/updateTime', [FiliereController::class, 'update_time'])->middleware('auth');

    

    


/* Route::get('/test',function(){

    $result = collect([]);
    
    $allGroupes = Groupe::all();
    $allGroupes->each(function($groupe)use($result){
        $stagNb = $groupe->stagiaires->count();
        if($stagNb != 0){
            $result->push($groupe);
        }
        
    });
    dd($result);


}); */



// Route::get('/test',function(){
//     $filtered = Etat::with('stagiaire.groupe')->get()->filter(function($value){

//             return $value->toArray()['stagiaire']['groupe']['filiere_id'] == 1;
//     });
//     dump($filtered->all());
// });