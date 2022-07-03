<?php

use App\Http\Controllers\Api\FiliereController;
use App\Models\Duration;
use App\Models\Etat;
use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

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

Route::get('filieres', [FiliereController::class, 'index_filieres']);
Route::get('stagiaires', [FiliereController::class, 'index_stagiaires']);
Route::get('filieres/{id}', [FiliereController::class, 'getgroupes']);
Route::get('groupes/{id}', [FiliereController::class, 'getstagiaires']);
Route::get('profs/{id}', [FiliereController::class, 'getprofs']);
Route::get('etats/{id}/{period}/{selected_period_debut}/{selected_period_fin}', [FiliereController::class, 'getetats']);

function getId($value, $array,string $col_name){
    foreach($array as $el){
        if($el[$col_name] == $value){
            return $el["id"];
        }
    }
}




Route::get('stagiaire/{id}', [FiliereController::class, 'StagInfo']);
    





Route::post('addAbsence',[FiliereController::class, 'addUpabsence']);
Route::post('addJustif',[FiliereController::class, 'addJustif']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/* Route to get all the groupes with their own graphes  */
//Groupe Name
//hours justified By Month 
//Hours Non Justified By Month
//make A Leaderoard OF the groupe sorted By Total Hours OR BY Non Justified Hours 

Route::get('/details',[FiliereController::class, 'details']);



/* Api to get the faculty that have absence */

Route::get('etatFil',[FiliereController::class, 'etatFil']);
    
/* Under Test  */

Route::post("/getSome",[FiliereController::class, 'getSome']);



Route::get("getDurations",function(){
    $duration = Duration::all()->where('active','on');
    return $duration;
});

Route::post("/updateEtat",[FiliereController::class, 'updateEtat']);

Route::post("/deleteEtat",[FiliereController::class, 'deleteEtat']);

Route::get('/loadPdf',[FiliereController::class, 'loadPdf']);/* function(){
    $pdf = Pdf::loadView('pdfs.stagPdf');
    return $pdf->download('hakim.pdf');
}); */