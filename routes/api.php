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
Route::post('/storeExcel',function(Request $request){
    // $baseExt = $request->file('base')->guessExtension();
    // $avantExt = $request->file('avant')->guessExtension();
    // return [
    //     'base'=>$baseExt,
    //     'avant'=>$avantExt
    // ];
    $request->file('base')->storeAs('excels',"base.csv");
    $request->file('avant')->storeAs('excels',"avant.csv");
    
    // $basePath = storage_path('/app/excels/base.csv');
    $avantPath = storage_path('/app/excels/avant.csv');
    $basePath= storage_path('/app/excels/base.csv');
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($basePath);
    $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
    $array = $sheet->toArray();
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($avantPath);
    $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
    $array_p = $sheet->toArray();


    

   
    $filieres = [];
    $exFil=[];/* filiere that has been adde to $filiere */
    
$i=1;
foreach ($array as $e) {
 
    if (!in_array($e[4],$exFil)
     && preg_match('/EL HANK/', $e[2])) {
        array_push($filieres, [
            "id" =>$i++,
            "code_fil" => $e[4],
            "nom_fil" => $e[5],
        ]);
        array_push($exFil,$e[4]);
    }
}
// echo "<pre>";
// print_r($filiere);
// echo "<pre>";



$txt = "INSERT INTO `filieres` (`code_fil`, `nom_fil`) VALUES \n\t\t";
// echo "<pre>";
// print_r($filiere);
// echo "<pre>";


$lenfil = count($filieres);
$x = 1;
foreach ($filieres as $fil){
    $code_fil = $fil["code_fil"];
    $nom_fil = $fil["nom_fil"];
    if($x == $lenfil){
        $txt .= "(\"$code_fil\",\"$nom_fil\");\n";
        break;
    }
    $txt .= "(\"$code_fil\",\"$nom_fil\"),\n\t\t";

    $x++;
}

// print($txt);

// /*--------------------------------------------------------------------------------------------------------------*/
// /*            ----------------------------------GROUPES TABLE------------------------------------              */
$groupes = [];
$nom_grList = [];
$i=1;
foreach ($array as $e) {
    $nom_gr = $e[7];
    $code_fil = $e[4];
    if (!in_array($nom_gr, $nom_grList) && 
    preg_match('/EL HANK/', $e[2]) &&
    preg_match('/\w+/',$nom_gr)
    ) {
        array_push($nom_grList,$nom_gr);
        array_push($groupes,[
            "id"=>$i++,
            "filiere_id"=>getId($code_fil,$filieres,"code_fil"),
            "nom_gr"=>$nom_gr
        ]);
    }
}


$lengroupe = count($groupes);
$x = 1;
$txt .="INSERT INTO `groupes` (`filiere_id`,`nom_gp`) VALUES \n\t\t";
foreach ($groupes as $gr){
    $nom_gr = $gr["nom_gr"];
    $filiere_id = $gr["filiere_id"];
    if($x == $lengroupe){
        $txt .= "(\"$filiere_id\",\"$nom_gr\");\n";
        break;
    }
    $txt .= "(\"$filiere_id\",\"$nom_gr\"),\n\t\t";

    $x++;
}


// /* --------------------------------------------------------------------------------------------------------------*/
// /*             ----------------------------------STAGIAIRES TABLE------------------------------------           */

// ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]');\n";
$stagiaires = [];
$mtr = [];
foreach ($array as $e) {
    if (!in_array($e[9], $mtr) && preg_match('/EL HANK/', $e[2]) && preg_match('/oui/', strtolower($e[10])) 
    && in_array($e[7], $nom_grList) ) {
        array_push($stagiaires, [
            
            "nom_st" => $e[15],
            "prenom_st" => $e[16],
            "groupe_id" => getId($e[7],$groupes,"nom_gr") ,
            "numero_personnelle" => $e[22],
        ]);
        array_push($mtr, $e[9]);
    }
}

$lenst = count($stagiaires);
$x = 1;
$txt .= "INSERT INTO `stagiaires` (`nom_st`, `prenom_st`, `groupe_id`,`numero_personnelle`) VALUES \n\t\t"; 
foreach ($stagiaires as $st){
    $nom_st = $st["nom_st"];
    $prenom_st = $st["prenom_st"];
    $groupe_id = $st["groupe_id"];
    $numero_personnelle = $st["numero_personnelle"];
    if($x == $lenst){
        $txt .= "(\"$nom_st\",\"$prenom_st\",\"$groupe_id\",\"$numero_personnelle\");\n";
        break;
    }
    $txt .= "(\"$nom_st\",\"$prenom_st\",\"$groupe_id\",\"$numero_personnelle\"),\n\t\t";

    $x++;
}


// /* --------------------------------------------------------------------------------------------------------------*/
// /*             ----------------------------------FORMATEURS TABLE------------------------------------           */


$profs = [];
$id_fm = [];
$i=1;
foreach (array_slice($array_p,1) as $e) {
    $test = preg_match('/[\s\w]{2,}/', $e[19]) && preg_match('/[\s\w]{2,}/',$e[20]);
    if(!in_array($e[19],$id_fm) && $test){
        array_push($id_fm,$e[19]);
        array_push($profs, [
            "id" => $i++,
            "id_tch"=>$e[19],
            "nom_prof" => $e[20],
        ]);
    }
   
    
}




$lenform = count($profs);
$x = 1;
$txt .="INSERT INTO `profs`(`nom_prof`) VALUES \n\t\t";/* ('[value-1]','[value-2]') */
foreach ($profs as $for){
  
    $nom_prof = $for["nom_prof"];
    if($x == $lenform){
        $txt .= "(\"$nom_prof\");\n";
        break;
    }
    $txt .= "(\"$nom_prof\"),\n\t\t";

    $x++;
}



// /* --------------------------------------------------------------------------------------------------------------*/
// /*             ----------------------------------FORMTEURS/GROUPES------------------------------------           */
// $sql = "INSERT INTO relations(prof_id,groupe_id) VALUES (?,?)";
/* e[8] =>nom_gr , e[19] => id_tch */
$relations = [];
$id_rel = [];
foreach (array_slice($array_p,1) as $e) {
    $arrRel = [
        "prof_id" =>getId($e[19],$profs,"id_tch") ,
        "groupe_id" => getId($e[8],$groupes,"nom_gr")
    ];
    $test = preg_match('/[\s\w]{2,}/', $e[8]) && preg_match('/[\s\w]{2,}/',$e[19]);
    if(!in_array($arrRel,$relations) && $test){
        array_push($relations,$arrRel);
    }
    
}

$lenrel = count($relations);
$x = 1;
$txt .="INSERT INTO `relations`(`prof_id`, `groupe_id`) VALUES \n\t\t";
foreach ($relations as $rel){
    $prof_id = $rel["prof_id"];
    $groupe_id = $rel["groupe_id"];
    if($x == $lenrel){
        $txt .= "(\"$prof_id\",\"$groupe_id\");\n";
        break;
    }
    $txt .= "(\"$prof_id\",\"$groupe_id\"),\n\t\t";

    $x++;
}

    $insertFile = fopen(database_path("/sql/data.sql"),"w");
    fwrite($insertFile,$txt);
    
    return [
        "message"=> "done"
    ];
    // $request->file('excel')->store('excels');
});



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