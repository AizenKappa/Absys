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
            $startTime = Carbon::parse($k->duration['h_debut']);
            $endTime = Carbon::parse($k->duration['h_fin']);
            $oneMonthAbs += $endTime->diffInMinutes($startTime)/60;
        }
        array_push($result,$oneMonthAbs);
    }
    return $result;
   
}


Route::get('stagiaire/{id}',function($id){
    $stag = Stagiaire::find($id);
    $absenceStag =Etat::where('stagiaire_id',$id)->get(); 
    
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

    foreach($absence_just as $k){
        $startTime = Carbon::parse($k->duration['h_debut']);
        $endTime = Carbon::parse($k->duration['h_fin']);
        $k["nbAbs"] = $endTime->diffInMinutes($startTime)/60;
         
    }
    
    $absence_nj =  $absenceStag->where('etat_justif','NJ');
    foreach($absence_nj as $k){
        $startTime = Carbon::parse($k->duration['h_debut']);
        $endTime = Carbon::parse($k->duration['h_fin']);
        $k["nbAbs"] = $endTime->diffInMinutes($startTime)/60;
         
    }
    $justData = monthAbs($absence_just);
    $njData = monthAbs($absence_nj);
            

  /* absence par Prof by order*/
  /*
  [
    'omar Hajoui'=>5,"Naji 
  ] 
   */
//   $prof=[];
 $st_prof = $gr->profs;
 $profs = [];
foreach($st_prof as $k){
    array_push($profs,[
        $k["nom_prof"] => 0
    ]);
   
}
$absProf = collect($profs)->collapse();
// dd($profs);


  foreach($absenceStag as $k){
    $startTime = Carbon::parse($k->duration['h_debut']);
    $endTime = Carbon::parse($k->duration['h_fin']);
    $k["nbAbs"] =floatval($endTime->diffInMinutes($startTime)/60) ;
    $profName = (string)$k->prof->nom_prof;
    $test = $absProf->get($profName);
    
    $absProf["$profName"] = floatval($test) + floatval($k["nbAbs"]);
  }
  $absProf = $absProf->sortDesc()->filter(function($item){
    return $item > 0;
  })->all();
  $res=[];
  foreach($absProf as $k=>$v){

    array_push($res,[
        "nom"=>$k,
        "hours"=>$v
    ]);
  }
  /*  */
    return [
        'absProf'=>$res,
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


/* Route to get all the groupes with their own graphes  */
//Groupe Name
//hours justified By Month 
//Hours Non Justified By Month
//make A Leaderoard OF the groupe sorted By Total Hours OR BY Non Justified Hours 

Route::get('/details',function(Request $request){
    
    $result = [
        
        "fillWithAbs"=>[],
        "exist"=>false,
        "info"=>[]
    ];
    $fillWithAbs = [];
    $groupeWithAbs = [];//les groupes qui contient au moins une absence
    
    $etats_just = Etat::with("stagiaire.groupe.filiere")->where("etat_justif","J")->get();
//    dd($etats_just);
    $etats_nj = Etat::with("stagiaire.groupe.filiere")->where("etat_justif","NJ")->get();
    // dd($etats_nj);
        $allEtat = Etat::with("stagiaire.groupe.filiere")->without("prof")->get()->all();
        foreach($allEtat as $e){
            $groupe = $e->stagiaire->groupe;
            $fil = $e->stagiaire->groupe->filiere;
            if(!in_array($groupe,$groupeWithAbs)){
                array_push($groupeWithAbs,$groupe);
            }   
            if(!in_array($fil,$fillWithAbs)){
                array_push($fillWithAbs,$fil);
            } 
         
           
        }
        $result["fillWithAbs"] = $fillWithAbs;
        
        $result["groupesWithAbs"] = $groupeWithAbs;

        foreach($groupeWithAbs as $groupe){
                        $nom_gp = $groupe->nom_gp;
                        $just_abs = monthAbs($etats_just->where("stagiaire.groupe.nom_gp","=",$nom_gp));
                        $nj_abs = monthAbs($etats_nj->where("stagiaire.groupe.nom_gp","=",$nom_gp));
                       
                        $total_h = 0;
                        $nj_h=0;
                        foreach($just_abs  as $el  ){
                            $total_h +=$el;
                            if($el > 0 ){
                                $result["exist"] = true;
                            }
                        }
                        foreach($nj_abs  as $el  ){
                            $total_h +=$el;
                            $nj_h +=$el;
                            if($el > 0 ){
                                $result["exist"] = true;
                            }
                        }
                        
                array_push($result["info"],[
                    "groupe" => $groupe,
                    "just_abs"=>$just_abs,
                    "nj_abs"=>$nj_abs,
                    "show"=>true,
                    "nj_h"=>$nj_h,
                    "total_h"=>$total_h
                            ]);
            
        }
    return $result    ;

});



/* Api to get the faculty that have absence */

Route::get('etatFil',function(){
    $allEtat = Etat::with("stagiaire.groupe.filiere")->get()->all();
    $allFil = Filiere::all();
    $allDurations = Duration::all();
    $allfill = $allFil->map(function($item){
        $item->push([
            "myGroupes"=>$item->groupes
        ]);
    });
   
    $allGroupes = Groupe::all();
    $result = [
        "allDurations"=>$allDurations,
        "allFilWithGroupes" =>$allFil,
        "allGroupes"=>$allGroupes,
        "fillWithAbs"=>[],
        "groupeWithAbs"=>[],
        "allAbs"=> $allEtat
        
    ];
    $fillWithAbs = [];
    $groupeWithAbs = [];//les groupes qui contient au moins une absence
    
        foreach($allEtat as $e){
            $groupe = $e->stagiaire->groupe;
            $fil = $e->stagiaire->groupe->filiere;
            if(!in_array($groupe,$groupeWithAbs)){
                array_push($groupeWithAbs,$groupe);
            }   
            if(!in_array($fil,$fillWithAbs)){
                
                array_push($fillWithAbs,$fil);
            } 
         
           
        }
        $result["groupeWithAbs"] = $groupeWithAbs;
        $result["fillWithAbs"] = $fillWithAbs;
        return $result;
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


// Route::post("/getProfs",function(Request $reques)){
//     $pro
// }



Route::get("getDurations",function(){
    $duration = Duration::all();
    return $duration;
});

Route::post("/updateEtat",function(Request $request){
    
    $id = $request->id;
   
    $prof_id = $request->prof_id;
    $duration_id = $request->duration_id;
    $date_abs = $request->date_abs;
    $seance = $request->seance;
    $etat_justif = $request->etat_justif;
    $motif = $request->motif;
    $last_duration_id = $request->last_duration_id;

    $etat = Etat::find($id);
    
    
    $etat->update([
        "prof_id"=>$prof_id,
        "duration_id"=>$duration_id,
        "date_abs"=>$date_abs,
        "seance"=>$seance,
        "etat_justif"=>$etat_justif,
        "motif"=>$motif,
    ]);

    $newDuration = Duration::find($duration_id);
    $lastDuration = Duration::find($last_duration_id);
    $startTime = Carbon::parse($newDuration->h_debut);
    $endTime = Carbon::parse($newDuration->h_fin);

    $newHour =floatval($endTime->diffInMinutes($startTime)/60) ;

    $startTime = Carbon::parse($lastDuration->h_debut);
    $endTime = Carbon::parse($lastDuration->h_fin);
    $lastHour=floatval($endTime->diffInMinutes($startTime)/60);

    $result = $newHour - $lastHour;
    //     >update([
    //         "heure_absence_st" => + $heure_absence_st
    //     ]);
    
    $stag = Stagiaire::find($etat->stagiaire_id);
    $heure_absence_st = $stag->heure_absence_st;

    $heure_absence_st = $heure_absence_st + $result;
    $stag->heure_absence_st = $heure_absence_st;
    $stag->save();
   
    return [
        "data"=>$request->all(),
        "test"=>"work"
    ];
});

Route::post("/deleteEtat",function(Request $request){
    
    $etat = Etat::find($request->id);
    $stag = Stagiaire::find($etat->stagiaire_id);
    $currentHour = floatval($stag->heure_absence_st);
    $startTime = Carbon::parse($etat->duration['h_debut']);
    $endTime = Carbon::parse($etat->duration['h_fin']);
    $heure_absence_st =floatval($endTime->diffInMinutes($startTime)/60) ;
    $stag->update([
        "heure_absence_st" =>$currentHour - $heure_absence_st
    ]);
    $result = $etat->delete();

    if($result){
        return "Deleted Successfully";
    }
    else{
        return "Something went Wrong";
    }


});