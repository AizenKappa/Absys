<?php

use App\Http\Controllers\Api\FiliereController;
use App\Models\Duration;
use App\Models\Filiere;
use App\Models\Groupe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::get('filieres/{id}', [FiliereController::class, 'getgroupes']);
Route::get('groupes/{id}', [FiliereController::class, 'getstagiaires']);
Route::get('stagsGroupe/{id}', [FiliereController::class, 'stagsGroupe']);
Route::get('profs/{id}', [FiliereController::class, 'getprofs']);
Route::get('stagiaire/{id}',[FiliereController::class, 'getstByid']);
Route::post('getMostStAbs',[FiliereController::class, 'getMostStAbs']);
Route::post('addAbsence',[FiliereController::class, 'addUpabsence']);
Route::post('addJustif',[FiliereController::class, 'addJustif']);
Route::post('getDurations',[FiliereController::class, 'getDurations']);
Route::post('/updateEtat',[FiliereController::class, 'updateEtat']);
Route::post('/deleteEtat',[FiliereController::class, 'deleteEtat']);
Route::get('/etatFil',[FiliereController::class, 'getEtatFil']);

Route::get('/getModules',function(){
    return Module::all();
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
    
/* Under Test  */

Route::post("/getSome",function(Request $request){
    $groupe_id = $request->groupe_id;
    $stagiaires = Groupe::find($groupe_id)->stagiaires;
    $profs = Groupe::find($groupe_id)->profs;
    return [
       "Stagiaires" => $stagiaires,
       "Profs" =>$profs
    ];


});
