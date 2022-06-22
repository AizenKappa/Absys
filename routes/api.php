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
Route::post('updateUser', [FiliereController::class, 'update_user']);

function monthAbs(Collection $type){
    
    $currentYear = intval(date("Y"));
    $currentMonth = intval(date("m"));
    if($currentMonth>=9 && $currentMonth <=12){
        $startYear = $currentYear;
        $endYear = $currentYear+1;
    }
    else if($currentMonth>=1 && $currentMonth <=7){
        $startYear = $currentYear-1;
        $endYear = $currentYear;
    }
    
    $months = [
        $startYear."-09",$startYear."-10",
        $startYear."-11",$startYear."-12",
        $endYear."-01",$endYear."-02",
        $endYear."-03",$endYear."-04",
        $endYear."-05",$endYear."-06",
        $endYear."-07"
    ];
    $result=[];
    foreach($months as $month){
        $thisMonthAbs = $type->whereBetween('date_abs',
        [$month.'-01',$month.'-31']);
        $oneMonthAbs = 0;
        foreach($thisMonthAbs as $k ){
            $startTime = Carbon::parse($k['h_debut']);
            $endTime = Carbon::parse($k['h_fin']);
            $oneMonthAbs += $endTime->diffInMinutes($startTime)/60;
        }
        array_push($result,$oneMonthAbs);
    }
    return $result;
   
}
Route::get('stagiaire/{id}',function($id){
    $stag = Stagiaire::find($id);
    $absenceStag =Etat::with('prof')->where('stagiaire_id',$id)->get(); 
    $groupe_id = $stag->groupe_id;
    $gr = Groupe::find($groupe_id);
    $groupe_name = $gr->nom_gp;
    $stFullName = $stag->nom_st." ".$stag->prenom_st;
    $st_total_abs = $stag->heure_absence_st;
    $class_total_abs = $gr->stagiaires
            ->where('id','<>',$id)
            ->pluck("heure_absence_st")
            ->reduce(function($carry,$element){
                return $carry + $element;
            });
    $absence_just =  $absenceStag->where('etat_justif','J');
    $absence_nj =  $absenceStag->where('etat_justif','NJ');

    $justData = monthAbs($absence_just);
    $njData = monthAbs($absence_nj);
            
  
    return [
        'groupe_name'=>$groupe_name,
        'groupe_id'=>$groupe_id,
        'stFullName'=>$stFullName,
        'class_total_abs'=>$class_total_abs,
        'st_total_abs'=>$st_total_abs,
        'monthly_abs'=>
        [
            "just"=> $justData,
            "nj"=> $njData
        ],

        'just_abs' =>$absence_just,
        'nj_abs'=>$absence_nj,
        ];
});




Route::post('addAbsence',[FiliereController::class, 'addUpabsence']);
Route::post('addJustif',[FiliereController::class, 'addJustif']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
