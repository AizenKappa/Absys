<?php

use App\Http\Controllers\Api\FiliereController;
use App\Models\Etat;
use App\Models\Groupe;
use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
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
Route::post('updateUser', [FiliereController::class, 'update_user']);

Route::get('stagiaire/{id}',function($id){
    $stag = Stagiaire::find($id);
    $groupe_id = $stag->groupe_id;
    $gr = Groupe::find($groupe_id);
    $class_total_abs = $gr->stagiaires->pluck("heure_absence_st")->reduce(function($carry,$element){
        return $carry + $element;
    });
    return [
        'groupe_id' => $groupe_id,
        'st_info'=>$stag,
        'class_total_abs' =>$class_total_abs
        ];
});


Route::post('addAbsence',[FiliereController::class, 'addUpabsence']);
Route::post('addJustif',[FiliereController::class, 'addJustif']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
