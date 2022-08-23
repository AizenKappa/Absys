<?php

use App\Http\Controllers\AbsysController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\Api\FiliereController;
use App\Http\Controllers\SessionController;
use App\Http\Resources\FiliereResource;
use App\Models\Groupe;
use App\Models\Absysyear;
use App\Models\Prof;
use App\Models\User;
use App\Models\Relation;
use App\Models\Module;
use App\Models\Filiere;
use Illuminate\Http\Request; 
use Carbon\Carbon;




use Intervention\Image\ImageManagerStatic as Image;
use App\Mail\NotifyMail;

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

    /* login functions */
Route::view('/user_info','login.user_info')->middleware('guest');
Route::get('/',[SessionController::class,'create'])->middleware('guest');
Route::post('/login',[SessionController::class,'store']);
Route::get('/logout',[SessionController::class,'destroy']);
Route::post('/check_user',[SessionController::class,'check']);
Route::post('/pwd_reset',[SessionController::class,'reset']);
Route::get('/sendEmail', function(Request $request){
    $request->session()->keep(['email']);
    return view("Email.verification");
});
Route::get('/pwdReset', function(Request $request){
    $request->session()->keep(['img','name']);
    return view("login.pwd_reset");
})->middleware("isvalidreset");
Route::post('/checkCode', [SessionController::class,'codeVerification'])->middleware('guest');
//--------------------------------------------------------------------------------


    /* Definition of Vue routes */
Route::view('/home','home')->middleware('auth');
Route::view('/just','home')->middleware('auth');
Route::view('/add','home')->middleware('auth');
Route::view('/detail','home')->middleware('auth');
Route::view('/stagiaire/{id}',"home")->middleware('auth');
Route::view('/editUser/{id}',"home")->middleware('auth');
Route::view('/Profile','home')->middleware('auth');
Route::view('/User',"home")->middleware('auth');
Route::view('/Estg',"home")->middleware('auth');
Route::view('/addUser',"home")->middleware('auth');
Route::view('/SearchByDate',"home")->middleware('auth');
Route::view('/editEtat',"home")->middleware('auth');
Route::view('/settings',"home")->middleware('auth');
Route::view('/addStag',"home")->middleware('auth');
Route::view('/test',"home")->middleware('auth');
Route::view('/impressions',"home")->middleware('auth');
//------------------------------------------------------------

    
    /* CRUD USER -----> */
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
Route::post('/updateEtat',[FiliereController::class, 'updateEtat']);
Route::post('/addNewStag', [FiliereController::class, 'addStag'])->middleware('auth');
Route::post('/updatePwdProfile', [FiliereController::class, 'updatePwdProfile'])->middleware('auth');
Route::post('/deleteEtat',[FiliereController::class, 'deleteEtat']);
Route::get('/addModule/{name}', [FiliereController::class, 'addModule']);
Route::post('/updateActive', [FiliereController::class, 'updateActive']);
Route::get('/updateyear/{id}', function(Request $request) { Auth::user()->update([ 'year' => $request->id ]); });
//--------------------------------------------------------------------------------

    /* Main functions */
Route::get('/getModules',[FiliereController::class, 'getModules']);
Route::get('/etatFil',[FiliereController::class, 'getEtatFil']);
Route::get('filieres/{id}', [FiliereController::class, 'getgroupes']);
Route::get('groupes/{id}', [FiliereController::class, 'getstagiaires']);
Route::post('getDurations',[FiliereController::class, 'getDurations']);
Route::post('/profile', [FiliereController::class, 'getprofile'])->middleware('auth');
Route::get('/deletPicture', [FiliereController::class, 'deletPicture'])->middleware('auth');
Route::get('etats/{id}/{period}/{selected_period_debut}/{selected_period_fin}', [FiliereController::class, 'getetats']);
Route::get('filieres', [FiliereController::class, 'index_filieres']);
Route::get('/getFilHours/{id}',[FiliereController::class, 'getFilhours'])->middleware('auth');
Route::get('profs/{id}', [FiliereController::class, 'getprofs']);
Route::get('/getUserGroupes/{id}', [FiliereController::class, 'getUserGroupes'])->middleware('auth');
Route::get('/details', [FiliereController::class, 'getDetails']);
Route::get('stagiaires', [FiliereController::class, 'index_stagiaires']);
Route::get('/settings/download/{year}', [FiliereController::class, 'export']);
Route::get('absysYear', [FiliereController::class, 'getAbsysYear']);
Route::post("/getSome",[FiliereController::class, 'getSome']);
Route::post('addAbsence',[FiliereController::class, 'addUpabsence']);
Route::post('addJustif',[FiliereController::class, 'addJustif']);
Route::get('stagsGroupe/{id}', [FiliereController::class, 'stagsGroupe']);
Route::get('stagiaireAbs/{id}',[FiliereController::class, 'getstByid']);
Route::post('getMostStAbs',[FiliereController::class, 'getMostStAbs']);
Route::get('/absysyears', function() { return Absysyear::all(); });
Route::get('/absysyearss', function(){ return [ 'data' => Absysyear::all(), 'active' => Auth::user()->year];});
Route::get('/getModulesFil', function() { return Module::all(); });
Route::post('/getFilieresProf', [FiliereController::class, 'getFilieresProf']);
Route::post('/checkNewYear', [FiliereController::class, 'checkNewYear']);
Route::post('/getGroupesProf',[FiliereController::class, 'getGroupesProf']);

//--------------------------------------------------------------------------------


//test insert data
Route::get('/testinsert', [FiliereController::class, 'store_excel']);/* store_excel_users */
Route::get('/insertusers', [FiliereController::class, 'store_excel_users']);


//impressions
Route::post('/envParModule', [PrintController::class, 'envParModule']);
Route::post('/envParProf', [PrintController::class, 'envParProf']);
Route::post('/loadSearchPdf',[PrintController::class, 'loadSearchPdf']);
Route::post('/loadStagPdf',[PrintController::class, 'loadStagPdf']);
Route::post('/loadPresencePdf',[PrintController::class, 'loadPresencePdf']);

Route::get('/getModules',[FiliereController::class, 'modules']);
Route::get('/getProfs',[FiliereController::class, 'profs']);