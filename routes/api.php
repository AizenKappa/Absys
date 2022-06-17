<?php

use App\Http\Controllers\Api\FiliereController;
use App\Models\Etat;
use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

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
Route::get('filieres/{id}', [FiliereController::class, 'getgroupes']);
Route::get('groupes/{id}', [FiliereController::class, 'getstagiaires']);
Route::get('profs/{id}', [FiliereController::class, 'getprofs']);
Route::get('etats/{id}/{period}/{selected_period_debut}/{selected_period_fin}', [FiliereController::class, 'getetats']);

Route::post('addAbsence', function (Request $request) {
    $stagiaire_ids = $request->stagiaire_ids;
    $prof_id = $request->prof_id;
    $absenceDuration = $request->absenceDuration;
    $seance = $request->seance;
    $date_abs = $request->typeSeance;
    $h_debut = '';
    $h_fin = '';
    $t1 = "08:30:00";
    $t2 = "11:00:00";
    $t3 = "13:30:00";
    $t4 = "16:00:00";
    $t5 = "18:30:00";
    $seanceTotal = 0;
    if ($absenceDuration == "allDay") {
        $h_debut = $t1;
        $h_fin  = $t5;
        $seanceTotal = 10;
    } else if ($absenceDuration == "matin") {
        $h_debut = $t1;
        $h_fin  = $t3;
        $seanceTotal = 5;
    } else if ($absenceDuration == "midi") {
        $h_debut = $t3;
        $h_fin  = $t5;
        $seanceTotal = 5;
    } else if ($absenceDuration == "seance-1") {
        $h_debut = $t1;
        $h_fin  = $t2;
        $seanceTotal = 2.5;
    } else if ($absenceDuration == "seance-2") {
        $h_debut = $t2;
        $h_fin  = $t3;
        $seanceTotal = 2.5;
    } else if ($absenceDuration == "seance-3") {
        $h_debut = $t3;
        $h_fin  = $t4;
        $seanceTotal = 2.5;
    } else if ($absenceDuration == "seance-4") {
        $h_debut = $t4;
        $h_fin  = $t5;
        $seanceTotal = 2.5;
    }
    foreach ($stagiaire_ids as $v) {
        Etat::create([
            "stagiaire_id" => $v,
            "prof_id" => $prof_id,
            "date_abs" => $date_abs ?? Carbon::now(),
            "h_debut" => $h_debut,
            "h_fin" => $h_fin,
            "seance" => $seance
        ]);
        $currentAbsence = Stagiaire::find($v)->heure_absence_st;

        Stagiaire::Where('id', $v)->update(['heure_absence_st' => ($currentAbsence + $seanceTotal)]);
    }

    return  [
        "stagiaire_id" => $v,
        "prof_id" => $prof_id,
        "date_abs" => $date_abs ?? Carbon::now(),
        "h_debut" => $h_debut,
        "h_fin" => $h_fin,
        "seance" => $seance
    ];
    //     $stag_ids =[];
    //     $seance =  $request->input("seanceType");
    //     $seanceTotal = 0;
    //     $seanceNum=[];
    //     $prof_id = $request->input("prof");
    //     $date_abs = $request->input("date_abs");

    //    foreach($data as $key => $item){

    //         if(Str::startsWith($key,'st-')){
    //             $id = Str::of($key)->explode('-')[1];//'st-12' => ['st','12']


    //             array_push($stag_ids,intval($id));

    //         }
    //         if(Str::startsWith($key,'seance-')){
    //             $s = Str::of($key)->explode('-')[1];//'st-12' => ['st','12']

    //             array_push($seanceNum,intval($s));
    //             $seanceTotal++;
    //             // dump($s);
    //             // dump($seanceNum);
    //             // dd();
    //         }
    //     }


    //     foreach($stag_ids as $v){
    //         Etat::create([
    //             "stagiaire_id"=>$v,
    //             "prof_id"=>$prof_id,
    //             "date_abs"=>$date_abs ?? Carbon::now(),
    //             "h_debut"=>"8:30:00",
    //             "h_fin"=>"10:30:00",
    //             "seance"=>$seance
    //         ]);
    //         $currentAbsence = Stagiaire::find($v)->heure_absence_st;

    //         Stagiaire::Where('id',$v)->update(['heure_absence_st'=>($currentAbsence + $seanceTotal*(2.5))]);
    //     }



});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
