<?php

use App\Http\Controllers\AbsysController;
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

Route::get('filieres', [FiliereController::class, 'index_filieres']);



    /*!!--Admin section --!!*/
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

Route::post('/addNewStag', [FiliereController::class, 'addstag'])->middleware('auth');

Route::post('/updatePwdProfile', [FiliereController::class, 'updatePwdProfile'])->middleware('auth');

Route::get('/getFilHours/{id}',[FiliereController::class, 'getFilhours'])->middleware('auth');

Route::post('/getGroupesProf', function(Request $request){

    $id = $request->id;

    $groupes = Groupe::Where('filiere_id',$id)->get();
    $nomFil =  Filiere::Find($id)->nom_fil;


    $result = [ "nomFil" => $nomFil, "groupes" => $groupes];

    return $result;
});

Route::post('/getFilieresProf', function(Request $request){

    $array = $request->list;
    $result = [];


    foreach ($array as $id){
        $groupes =  Groupe::Where('filiere_id',$id)->get()->toArray();
        $nomFil =  Filiere::Find($id)->nom_fil;
        $result[] = [ "nomFil" => $nomFil, "groupes" => $groupes];
    }

    return $result;

});

Route::post('/updateActive', function(Request $request){

    User::Find((int)$request->id)->update(['active' => $request->active]);
    return [
        'message' => 'success'
    ];
});

Route::post('/checkNewYear', function(Request $request){

    $year = $request->debut.'-'.$request->fin;
    $check = Absysyear::Where('year',$year)->count() == 0;

    if($check)
        return ['message' => true];
    return ['message' => false, 'year' => $year];
});



    

Route::get('/getUserGroupes/{id}', [FiliereController::class, 'getUserGroupes'])->middleware('auth');


Route::get('absysYear', [FiliereController::class, 'getAbsysYear']);

    
Route::get('etats/{id}/{period}/{selected_period_debut}/{selected_period_fin}', [FiliereController::class, 'getetats']);
Route::get('/details', [FiliereController::class, 'getDetails']);
Route::get('stagiaires', [FiliereController::class, 'index_stagiaires']);

Route::get('/test', [AbsysController::class, 'addYear']);

Route::get('/testinsert', [FiliereController::class, 'store_excel']);



Route::get('/getModulesFil', function()
{
    return Module::all();
   
});

Route::get('/addModule/{name}', function(Request $request)
{
    return Module::create([
        'nom_module' => $request->name
    ]);
   
});



/* Route::get('/testuser', [FiliereController::class, 'addUser']); */



//--------------------------------------------------------------------------------
/* $Filieres = explode(",",$request->list);
$model = Module::all();
$filiere = Filiere::all();
$result = [];

foreach($Filieres as $Fil)
{
    $Modules = Relation::Where('filiere_id',(int)$Fil)->get()->toArray();
    $filModules = [];
    $existModules = [];
    foreach($Modules as $md)
    {
        $string = $md['filiere_id'].$model->where('id',$md['module_id'])->first()->nom_module;

        if(!in_array($string,$existModules)){
            $filModules[] = [
                "module_id" => $md['module_id'],
                "nom_module" => $model->where('id',$md['module_id'])->first()->nom_module,
            ];
            array_push($existModules,$string);
        }
    }
    $result[] = [
        "nom_fil" => $filiere->where('id',(int)$Fil)->first()->nom_fil,
        "Modules" => $filModules
    ];
}
return $result; */
// -------------------------------------------------------------------------------

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