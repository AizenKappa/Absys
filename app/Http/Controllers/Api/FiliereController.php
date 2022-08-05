<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FiliereResource;
use App\Models\Duration;
use App\Models\Filiere;
use App\Models\Prof;
use App\Models\GroupeProf;
use App\Models\Module;
use Illuminate\Support\Facades\Http;
use App\Models\Relation;
use App\Models\Stagiaire;
use App\Models\Groupe;
use App\Models\User;
use App\Models\Absysyear;
use App\Models\GroupeModule;
use App\Models\ProfModule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPUnit\TextUI\XmlConfiguration\Group;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class FiliereController extends Controller
{

    public function index_filieres()
    {   
        if(Auth::user()->formateur_id == -1){
            return [
                'prof_id' => false ,
                'data' => FiliereResource::collection(Filiere::all())
            ];
        }else{
            $ids = Prof::find(Auth::user()->formateur_id)->groupes->pluck('filiere_id');
            return [
                'prof_id' => Auth::user()->formateur_id,
                'data' => FiliereResource::collection(Filiere::WhereIn('id',$ids)->get())
            ];
        }
        
    }

    public function index_stagiaires()
    {
        $user_id = Auth::user()->formateur_id;

        
        if($user_id == -1){
            return Stagiaire::With('groupe')->get();
        }else{
            

            $result = collect([]);

            $Stagiaires = Stagiaire::With('groupe.profs')->get();

            $Stagiaires->each(function($st)use($result,$user_id){
                if( in_array($user_id, $st->groupe->profs->pluck('id')->toArray()) ){
                    $result->push($st);
                }
            });

            return $result;
        }
    }


    public function getgroupes(Request $request)
    {
        
        return FiliereResource::collection(Filiere::Find($request->id)->groupes);
    }


    public function getstagiaires(Request $request)
    {
        return FiliereResource::collection(Groupe::Find($request->id)->stagiaires);
    }

    public function index_users()
    {
        $id = Auth::user()->id;
        return FiliereResource::collection(User::all()->filter( function($e) use($id) {
            return $e->id != $id;
        }));
    }

    public function userById(Request $request) {

        $user = User::Find($request->id) ;
        return [
            'user_id' => $user->id,
            'cin' => $user->cin,
            'email' => $user->email,
            'formateur_id' => (int)$user->formateur_id,
            'firstname' => $user->firstname,
            'role' => $user->role,
            'lastname' => $user->lastname,
        ];

    }

    public function editThisUser (Request $request){

        $password = User::Find(Auth::user()->id)->password;

        if (Hash::check($request->password, $password)){


            $cin = $request->cin;
            $email = $request->email;

            $user = User::Find($request->id);

            if($cin != null){
                $search1 = User::Where('cin',$cin)->count();
                if($search1 > 0) { return ['champ' => 'cin' ,'message' => 'Cin existe déja']; }
            }else{
                $cin = $user->cin;
            }


            if($email != null){
                $search2 = User::Where('email',$request->email)->count();
                if($search2 > 0) { return ['champ' => 'email' ,'message' => 'Cet E-mail déja existe']; }
            }else{
                $email = $user->email;
            }
            

                $user->update([
                    'firstname' => $request->first,
                    'lastname' => $request->last,
                    'cin' => $cin,
                    'email' => $email
                ]);


                if($user->role == 'Formateur'){
                    return $this->updateGroupesProf($user->formateur_id, $request->groupes, $request->copie);
                }
                else{
                    return [
                        'message' => 'user edited successe'
                    ];
                }

            
            
        }else{

            return [
                'champ' => 'password',
                'message' => 'Incorrecte mot de passe'
                
            ];
        }
    }

    public function updateGroupesProf($idP,$groupes,$copie)
    {
        /* GroupeModule::where('groupe_id',$groupe_id)->where('module_id',$module['id'])->first()->delete(); */
        return $copie;

        $delete_array = [];
        
        foreach ($copie as $gp)
        {
            $idg = Groupe::Where('nom_gp',$gp['nom_gp'])->first()->id;
            foreach($gp['modules'] as $module){
                $delete_array[] = [
                    'module_id' => $module['id'],
                    'groupe_id' => $idg
                ];
            }
        }
        
        return $delete_array;

        $currentGroupes = GroupeProf::Where('prof_id',$idP)->get();
        $currentModules = ProfModule::Where('prof_id',$idP)->get();

        $array_gm = $array_gp = $array_pm = [];

        foreach($currentGroupes as $curentgp){
            $curentgp->delete();
        }

        foreach($currentModules as $curentmd){
            $curentmd->delete();
        }
        

        $groupeModel = Groupe::all();
        
        foreach ($groupes as $groupe) {

            $groupe_id = $groupeModel->where('nom_gp',$groupe['nom_gp'])->first()->id;

            $array = [
                'prof_id' => $idP,
                'groupe_id' => $groupe_id
            ];
            
            
            if(!in_array($array,$array_gp))
                $array_gp[] = $array;
            
            foreach($groupe['modules'] as $module){

                $array = [
                    'module_id' => $module['id'],
                    'groupe_id' => $groupe_id
                ];
                if(!in_array($array,$array_gm))
                    $array_gm[] = $array;

                
                $array = [
                    'prof_id' => $idP,
                    'module_id' => $module['id']
                ];
                if(!in_array($array,$array_pm))
                    $array_pm[] = $array;
            }
        }


        /* return [
            'array_gp' => $array_gp,
            'array_gm' => $array_gm,
            'array_pm' => $array_pm
        ]; */

        GroupeProf::insert($array_gp);
        ProfModule::insert($array_pm);
        GroupeModule::insert($array_gm);


        return [
            'message' => 'user edited successe'
        ];

    }

    public function deletuser(Request $request)
    {
        

        User::Find($request->id)
            ->delete();

        return [
            'message' => 'delet successe'
        ];
    }

    public function updatePwdUser(Request $request) {

        $password = User::Find(Auth::user()->id)->password;

        if (Hash::check($request->authPwd, $password)){

            User::Find($request->id)
            ->password = $request->password;

            return [
                'message' => 'Password updated successefuly'
            ];
        }else{

            return [
                'champ' => 'password',
                'message' => 'Incorrecte mot de passe'
                
            ];

        }
    }

    public function getprofs(Request $request)
    {
        return FiliereResource::collection(Groupe::Find($request->id)->profs);
    }

    public function getAbsysYear()
    {
        $boolean = (int)Absysyear::Where('active','on')->first()->current;

        if($boolean == 0){
            return false;
        }
        return true;
    }

    public function getetats(Request $request)
    {

        $id = $request->id;
        $boolean = (int)Absysyear::Where('active','on')->first()->current;
        $year = Absysyear::Where('active','on')->first()->year;
        $model = 'App\Models\Etat'.$year;

        if($boolean == 0)
        {

            if($id == 'Tous')
                return FiliereResource::collection($model::orderBy('date_abs','desc')->get());

            else
                return FiliereResource::collection($model::Where('stagiaire.groupe.filiere_id',$id)
                ->orderBy('date_abs','desc')->get());

        }

        else{

            $period = $request->period;
            $curr_month = (int)date("m");
            $cuur_year = (int)date("Y");
            //for the whole year
            if($period == "year"){ 
                if($curr_month >= 1 && $curr_month <= 7 ){
                    $period_debut = ($cuur_year-1).'-08-30';
                    $period_fin = $cuur_year.'-08-30';
                }else{
                    $period_debut = $cuur_year.'-08-30';
                    $period_fin = ($cuur_year+1).'-08-30';
                }
            }
            

            //for current week
            elseif($period == "week"){
                $period_debut = Carbon::now()->startOfWeek()->format('Y-m-d');
                $period_fin = Carbon::now()->endOfWeek()->format('Y-m-d');
            }

            //for last week
            elseif($period == "subweek"){
                $period_debut = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d');
                $period_fin = Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d');
            }

            //for current month
            elseif($period == "month"){
                $period_debut = Carbon::now()->startOfMonth()->format('Y-m-d');
                $period_fin = Carbon::now()->endOfMonth()->format('Y-m-d');
            }

            //for last month
            elseif($period == "submonth"){
                $period_debut = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
                $period_fin = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
            }

            //if he chooses date manually
            else{
                $period_debut = $request->selected_period_debut;
                $period_fin = $request->selected_period_fin;

            }

            
            $user_id = Auth::user()->formateur_id;

            /* return $user_id; */

            $period_debut = "2021-08-30";
            $period_fin = "2023-08-30";


            if($user_id == -1){

                if($id == 'Tous')
                return FiliereResource::collection($model::whereBetween('date_abs', [$period_debut, $period_fin ])
                ->orderBy('date_abs','desc')->get());

                else
                return FiliereResource::collection($model::Where('stagiaire.groupe.filiere_id',$id)
                ->WhereBetween('date_abs',[$period_debut, $period_fin ])->orderBy('date_abs','desc')->get());

            }else{

                if($id == 'Tous')
                return FiliereResource::collection($model::whereBetween('date_abs', [$period_debut, $period_fin ])
                ->where('prof_id',$user_id)->orderBy('date_abs','desc')->get());
                else

                return FiliereResource::collection($model::Where('stagiaire.groupe.filiere_id',$id)
                ->WhereBetween('date_abs',[$period_debut, $period_fin ])
                ->where('prof_id',$user_id)->orderBy('date_abs','desc')->get());

            }
        }
        
    }

    public function getUserGroupes(Request $request,)
    {
        $groupes = Prof::Find($request->id)->groupes->all();

        $result = [];
        $existGp = [];
        $ModelGP = Groupe::all();
    
        $profModules = Prof::Find($request->id)->modules->pluck('nom_module')->all();
    
        foreach($groupes as $gp){
            $groupe = (object)[
                'id' => $gp->id,
                'nom_gp' => $gp->nom_gp,
            ];
    
            if(!in_array($groupe,$existGp)){
    
                $prepare = [];
                $modules = Groupe::Find($groupe->id)->modules->whereIn('nom_module',$profModules);
                             
                foreach( $modules as $module ){
                    $prepare[] = (object)[
                        'id' => $module->id,
                        'nom_module' => $module->nom_module
                    ];
                }
    
                $result[] = [
                    'nom_gp' => $groupe->nom_gp,
                    'modules' => $prepare
                ];
    
                array_push($existGp,$groupe);
    
            }
                
        }
    
    
    
        return $result; 
    }

    public function getDetails()
    {
        
        $year = Absysyear::Where('active','on')->first()->year;
        $model = 'App\Models\Etat'.$year;


        $result = [
            "fillWithAbs"=>[],
            "exist"=>false,
            "info"=>[
                "totalHoursAbs" => Stagiaire::Wherenot('heure_absence_st',0)->get()->pluck('heure_absence_st')->sum(),
                "info" => []
            ]
        ];
        $fillWithAbs = [];
        $groupeWithAbs = [];//les groupes qui contient au moins une absence
        
        $etats_just = $model::with("stagiaire.groupe.filiere")->where("etat_justif","J")->get();
        //    dd($etats_just);
        $etats_nj = $model::with("stagiaire.groupe.filiere")->where("etat_justif","NJ")->get();
        // dd($etats_nj);
    
        $user_id = Auth::user()->formateur_id;

        if($user_id == -1){
            $allEtat = $model::with("stagiaire.groupe.filiere")->without("prof")->get();
        }else{
            $allEtat = $model::with("stagiaire.groupe.filiere")->without("prof")->where('prof_id',$user_id)->get();
        }
    
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
                    
            $id_gp = $groupe->id;                
            $just_abs = $this->monthAbs($etats_just->where("stagiaire.groupe.id","=",$id_gp));
            $nj_abs = $this->monthAbs($etats_nj->where("stagiaire.groupe.id","=",$id_gp));    
            $total_h = 0;
            $nj_h=0;

            foreach($just_abs  as $el  ){
                $total_h +=$el;
                if($el > 0 ){ $result["exist"] = true; }
            }

            foreach($nj_abs  as $el  ){
                $total_h +=$el;
                $nj_h +=$el;
                if($el > 0 ){ $result["exist"] = true; }
            }
                
            array_push($result["info"]["info"],[
                "groupe" => $groupe, "just_abs"=>$just_abs, "nj_abs"=>$nj_abs, "show"=>true, "total_h"=>$total_h, 
                "nj_h"=>$nj_h,
            ]);  
                    
        }
        return $result;
    }

    public function monthAbs($type)
    {
    
        /* $currentYear = intval(date("Y"));
        $currentMonth = intval(date("m"));

        if($currentMonth>=9 && $currentMonth <=12){
            $startYear = $currentYear;
            $endYear = $currentYear+1;
        }
        else if($currentMonth>=1 && $currentMonth <=7){
            $startYear = $currentYear-1;
            $endYear = $currentYear;
        } */

        $year = Absysyear::Where('active','on')->first()->year;
        $startYear = $year[0].$year[1].$year[2].$year[3];
        $endYear = $year[4].$year[5].$year[6].$year[7];
        
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

    public function getstByid(Request $request)
    {

        $id = $request->id;
        $stag = Stagiaire::find($id);
        $absenceStag =$model::where('stagiaire_id',$id)->get(); 
        
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
        $justData = $this->monthAbs($absence_just);
        $njData = $this->monthAbs($absence_nj);
                
        $st_prof = $gr->profs;
        $profs = [];
        foreach($st_prof as $k){
            array_push($profs,[
                $k["nom_prof"] => 0
            ]);
        }
        $absProf = collect($profs)->collapse();

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
    }

    public function getEtatFil()
    {
        $year = Absysyear::Where('active','on')->first()->year;
        $model = 'App\Models\Etat'.$year;

        $allEtat = $model::with("stagiaire.groupe.filiere")->get()->all();
        $allFil = Filiere::all();
        $allDurations = Duration::Where('active','on')->get();
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
    }

    public function updateEtat(Request $request)
    {
        $year = Absysyear::Where('active','on')->first()->year;
        $model = 'App\Models\Etat'.$year;

        $id = $request->id;
   
        $prof_id = $request->prof_id;
        $duration_id = $request->duration_id;
        $date_abs = $request->date_abs;
        $seance = $request->seance;
        $etat_justif = $request->etat_justif;
        $motif = $request->motif;
        $last_duration_id = $request->last_duration_id;
    
        $etat = $model::find($id);
        
        
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
    }

    public function deleteEtat(Request $request)
    {
        $year = Absysyear::Where('active','on')->first()->year;
        $model = 'App\Models\Etat'.$year;

        $etat = $model::find($request->id);
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
    }

    public function addUpAbsence(Request $request)
    {
        

        $year = Absysyear::Where('active','on')->first()->year;
        $model = 'App\Models\Etat'.$year;



        $stagiaire_ids = $request->stagiaire_ids;
        $prof_id = $request->prof_id;
        $duration_id = $request->duration_id;
        $seance = $request->seance;
        $date_abs = $request->date_abs;
       
        $dura = Duration::find($duration_id);
       
        $startTime = Carbon::parse($dura->h_debut);
        $endTime = Carbon::parse($dura->h_fin);
        $hours = $endTime->diffInMinutes($startTime)/60;


        foreach ($stagiaire_ids as $v) {
            $model::create([
                "stagiaire_id" => $v,
                "prof_id" => $prof_id,
                "date_abs" =>$date_abs ?? Carbon::now() ,
                "duration_id"=>$duration_id,
                "seance" => $seance,
            ]);
            
            $currentAbsence = Stagiaire::find($v)->heure_absence_st;
    
            Stagiaire::Where('id', $v)->update(['heure_absence_st' => ($currentAbsence + $hours)]);
        }

        

        return [
            "message" => "L'absence ajoutée avec Succés"

        ];
      
    }


    public function updateStatus(){
        if(Auth::check()){
            $user = User::Find(Auth::user()->id);
            $user->status = time()+10;
            $user->save();
        }
    }

    public function update_stagiaire(Request $request) {
        
        Stagiaire::Find($request->id)->update([
            'nom_st' => $request->first,
            'prenom_st' => $request->last,
            'status' => $request->status,
            'numero_personnelle' => $request->num
        ]);
    }
    

    public function addJustif(Request $request)
    {
        $year = Absysyear::Where('active','on')->first()->year;
        $model = 'App\Models\Etat'.$year;

       $absences_ids = $request->absences_ids;

       if($request->motif === "autre") $motif = $request->manualle_motif;
       else $motif = $request->motif;
       
       $model::whereIn('id',$absences_ids)->update(['etat_justif' => 'J','motif' => $motif]);
    }

    public function getAuthUser()
    {
        $user = User::Find(Auth::id()) ;
        return [
            'user_id' => $user->id,
            'cin' => $user->cin,
            'email' => $user->email,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'role' => $user->role,
            'image' => asset('images/'. $user->picture_path )
        ];
        
    }
    

    public function deletPicture()
    {

        $user = User::Find(Auth::id()) ;

        $user->picture_path = "undefindedUser.png";

        $user->save();

        return [

            'status' => 'pucture deleted'
        ];
    }


    public function getprofile(Request $request)
    {

        $image = request()->file('image');
        $imageName = $image->getClientOriginalName();
        $imageName = time().'_'.$imageName;


        $img = Image::make($image);
        $img->fit(300, 300);
        $img->save(public_path('/images/'. $imageName));

        $id = Auth::id();
        $user = User::Find($id);
        $user->picture_path = $imageName;
        $user->save();

        return [

            'status' => 'update successed'
        ];



    }


    public function update_user(Request $request)
    {
        $password = User::Find($request->id)->password;

        if (Hash::check($request->password, $password))
        {
            $cin = $request->cin;
            $email = $request->email;

            
            if($request->cin != null){
                $search1 = User::Where('cin',$request->cin)->count();
                if($search1 > 0) { return ['champ' => 'cin' ,'message' => 'Cin existe déja']; }
            }else{
                $cin = User::Find($request->id)->cin;
            }


            if($request->email != null){
                $search2 = User::Where('email',$request->email)->count();
                if($search2 > 0) { return ['champ' => 'email' ,'message' => 'Cet E-mail déja existe']; }
            }else{
                $email = User::Find($request->id)->email;
            }
            
            User::Find($request->id)->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'cin' => $cin,
                'email' => $email
            ]);

            return [
                'message' => 'update_successed',
            ];

        }else{ 
            return [
                'champ' => 'password', 
                'message' => 'wrong password'
            ]; }
       
    }

    public function addUser(Request $request)
    {   

        $password = User::Find(Auth::user()->id)->password;

        if (Hash::check($request->curpwd , $password)){
            
            
            $search1 = User::Where('email',$request->email)->count();
            if($search1 > 0) { return ['champ' => 'email' ,'message' => 'Cet E-mail déja existe']; }


            $search2 = User::Where('cin',$request->cin)->count();
            if($search2 > 0) { return ['champ' => 'cin' ,'message' => 'Cin existe déja']; }
            

            $user = new User;
            $user->firstname =  $request->first;
            $user->lastname =  $request->last;
            $user->cin =  $request->cin;
            $user->email =  $request->email;
            $user->password =  $request->pwd;
            $user->role = $request->role;



            if($request->role == "Formateur")
            {
                
                $Prof = Prof::all();
                $code = Str::random(8);

                while ($Prof->where('code_prof',$code)->count() > 0) {
                    $code = Str::random(8);
                }

                $prof = Prof::create([
                    'code_prof' => $code,
                    'nom_prof' => $request->first.' '.$request->last
                ]);

                $id_prof = $prof->id;
                $modules = $request->modules;

                $user->formateur_id = $id_prof;
                $Groupe = Groupe::all();
                
                $groupeProf = $profModule = $groupeModule = [];
                

                foreach($modules as $module)
                {
                    $list = explode("*$*",$module);
                    $groupeId =  $Groupe->where('nom_gp',$list[1])->first()->id;

                    $array_gp = [
                        'prof_id' => $id_prof,
                        'groupe_id' => $groupeId
                    ];
                    if(!in_array($array_gp,$groupeProf))
                        $groupeProf[] = $array_gp;


                    $array_pm = [
                        'prof_id' => $id_prof,
                        'module_id' => $list[0]
                    ];
                    if(!in_array($array_pm,$profModule))
                        $profModule[] = $array_pm;


                    $array_gm = [
                        'module_id' => $list[0],
                        'groupe_id' => $groupeId,
                    ];
                    
                    $boolean = Groupe::Find($groupeId)->modules->where('id',$list[0])->count() == 0;
                    if(!in_array($array_gm,$groupeModule) && $boolean)
                        $groupeModule[] = $array_gm;

                }

                GroupeModule::insert($groupeModule);
                GroupeProf::insert($groupeProf);
                ProfModule::insert($profModule);
                
            }else{
                $user->formateur_id = -1;
            }

            $user->save();
            
            return [
                'message' => 'user added successe'
                
            ];
        }else{
            return [ 
                'champ' => 'password' ,
                'message' => 'Incorrecte mot de passe'
            ];
        }
    }

    public function store_excel(Request $request)
    {

        $baseExt = $request->file('base')->guessExtension();
        $avantExt = $request->file('avant')->guessExtension();

            /* storing the files */
        $request->file('base')->storeAs('excels',"base.".$baseExt);
        $request->file('avant')->storeAs('excels',"avant.".$avantExt);

            /* Files Path */
        $basePath= storage_path('/app/excels/base.'.$baseExt);
        $avantPath = storage_path('/app/excels/avant.'.$avantExt);


        if($baseExt == "csv"){

            $array = [];
            $handle = fopen($basePath, "r");
            while (( $row = fgetcsv($handle)) !== false) {
                $array[] = $row;
            }
            $array = mb_convert_encoding($array, "UTF-8", "auto");

        }else{
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($basePath);
            $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
            $array = $sheet->toArray();
        }



        if($avantExt == "csv"){
            $array_p = [];
            $handle = fopen($avantPath, "r");
            while (( $row = fgetcsv($handle)) !== false) {
                $array_p[] = $row;
            }
            $array_p = mb_convert_encoding($array_p, "UTF-8", "auto");

        }
        else{
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($avantPath);
            $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
            $array_p = $sheet->toArray();
        }

        return $this->insertData($array, $array_p);

    }

    public function insertData($array, $array_p)
    {
        
        // ----------------------------------Filiere TABLE-------------------------------------
        $Filieres = Filiere::all()->pluck('nom_fil')->toArray();

        foreach ($array as $e)
        {
            if (!in_array($e[5],$Filieres) && preg_match('/EL HANK/', $e[2]) && preg_match('/\w+/',$e[5]))
            {
                Filiere::create([
                    "code_fil" => $e[4],
                    "nom_fil" => $e[5],
                ]);
                $Filieres = Filiere::all()->pluck('nom_fil')->toArray();
            }
        }

        // ----------------------------------GROUPES TABLE--------------------------------------
        $groupes = Groupe::all()->pluck('nom_gp')->toArray();
        foreach ($array as $e) 
        {
            if (!in_array($e[7],$groupes) && preg_match('/EL HANK/', $e[2]) && preg_match('/\w+/',$e[7]))
            {
                Groupe::create([
                    "filiere_id" => Filiere::Where('code_fil',$e[4])->first()->id,
                    "nom_gp" => $e[7],
                ]);
                $groupes = Groupe::all()->pluck('nom_gp')->toArray();
            }
        }

        // ----------------------------------STAGIAIRES TABLE------------------------------------

        $matricules = [];  $groupes = Groupe::all()->pluck('nom_gp');

        $allgroupes = Groupe::all();
        $stagiaires = [];


        foreach ($array as $e) 
        {
            $regex = preg_match('/EL HANK/', $e[2]) && preg_match('/oui/', strtolower($e[10]));
            if (!in_array($e[9],$matricules) && $regex && $groupes->contains($e[7]))
            {
                $stagiaires[] = [
                    "matricule_st" =>$e[9],
                    "nom_st" => $e[15],
                    "prenom_st" => $e[16],
                    "groupe_id" => $allgroupes->Where('nom_gp',$e[7])->first()->id,
                    "numero_personnelle" => $e[22],
                ];

                array_push($matricules, $e[9]);
            }
        }

        Stagiaire::insert($stagiaires);

        
        // -----------------------------FORMATEURS TABLE && MODULE TABLE---------------------------
        $Formateurs = Prof::all()->pluck('nom_prof')->toArray();
        $Modules = Module::all()->pluck('nom_module')->toArray();
        $array_profs = [];
        $array_modules = [];

        foreach (array_slice($array_p, 1) as $e)
        {
            $regex = preg_match('/[\s\w]{2,}/', $e[19]) && preg_match('/[\s\w]{2,}/',$e[20]);
            if($regex)
            {
                if (!in_array($e[20],$Formateurs))
                {
                    $array_profs[] = [
                        "code_prof" => $e[19],
                        "nom_prof" => $e[20]
                    ];

                    $Formateurs[] = $e[20];
                }
                if (!in_array($e[17],$Modules) && preg_match('/[\s\w]{2,}/',$e[17]))
                {
                    $array_modules[] = [
                        "nom_module" => $e[17],
                    ];

                    $Modules[] = $e[17];
                }
            }
        }

        Prof::insert($array_profs);
        Module::insert($array_modules);



        // ----------------------------------RELATIONS-----------------------------------------------
        $modules = Module::all()->pluck('nom_module');
        $profs = Prof::all()->pluck('nom_prof');
        $moduleModel = Module::all(); $groupeModel = Groupe::all(); $profModel = Prof::all();
        $profGroupes = $profModulles = $groupeModulles = [];

        foreach (array_slice($array_p, 1) as $e)
        {
            if($modules->contains($e[17]) && $groupes->contains($e[8]) && $profs->contains($e[20])
                && preg_match('/[\s\w]{2,}/', $e[17]) && preg_match('/[\s\w]{2,}/',$e[5]) && preg_match('/[\s\w]{2,}/',$e[7]))
            {
                $groupe_id = $groupeModel->where('nom_gp',$e[8])->first()->id;
                $module_id = $moduleModel->where('nom_module',$e[17])->first()->id;
                $prof_id = $profModel->where('nom_prof',$e[20])->first()->id;
                
                $array_pg = [
                    "prof_id" => $prof_id,
                    "groupe_id" => $groupe_id
                ];
                $array_pm = [
                    "module_id" => $module_id,
                    "prof_id" => $prof_id
                ];
                $array_gm = [
                    "module_id" => $module_id,
                    "groupe_id" => $groupe_id
                ];


                if(!in_array($array_pg,$profGroupes))
                    $profGroupes[] = $array_pg;
                if(!in_array($array_pm,$profModulles))
                    $profModulles[] = $array_pm;
                if(!in_array($array_gm,$groupeModulles))
                    $groupeModulles[] = $array_gm;
                    
            }
        }
        GroupeProf::insert($profGroupes);
        GroupeModule::insert($groupeModulles);
        ProfModule::insert($profModulles);
        // -------------------------------------------------------------------------------------------


        return [
            "message"=> "success"
        ];
    }

    public function getId($value, $array,string $col_name)
    {
        foreach($array as $el){
            if($el[$col_name] == $value){
                return $el["id"];
            }
        }
    }

    public function check_time()
    {

        $startTime = Carbon::parse(Duration::First()->updated_at);
        $finishTime = Carbon::parse(Carbon::now());
        $time = $finishTime->diffInSeconds($startTime);

        if($time <  86400 ){
            return [
                "ready" => "no",
                "time" => 86400 - $time,
                "active" => Duration::First()->active
            ];
        }else{
            return [
                "ready" => "yes",
                "active" => Duration::First()->active
            ];
        }
        
    }

    public function update_time()
    {

            $startTime = Carbon::parse(Duration::First()->updated_at);
            $finishTime = Carbon::parse(Carbon::now());

            $time = $finishTime->diffInSeconds($startTime);

            if($time >= 86400)
            {

                Duration::Where('active','off')
                ->update([
                    'active' => 'ready'
                ]);

                Duration::Where('active','on')
                ->update([
                    'active' => 'off'
                ]);

                Duration::Where('active','ready')
                ->update([
                    'active' => 'on'
                ]);

                return [
                    "type" => "success",
                    "message" => "Time Updated successful"
                ];
            }
            
            else
            {
                return [
                    "type" => "wrong",
                    "message" => "Vou devez attendre le temps ci-dessus"
                ];
            }
    }

    public function addStag(Request $request)
    {   


        $password = User::Find(Auth::user()->id)->password;

        if (Hash::check($request->curpwd , $password)){

            $search = Stagiaire::Where('matricule',$request->mat)->count();

            if($search > 0) { return ['champ' => 'mat' ,'message' => 'Cet Matricule déja existe']; }

           
            Stagiaire::create([
                'matricule' => $request->mat,
                'nom_st' => $request->first,
                'prenom_st' => $request->last,
                'groupe_id' => $request->gp
            ]);

            return [
                'message' => 'stagiaire added successe'
                
            ];
        }else{
            return [ 
                'champ' => 'password' ,
                'message' => 'Incorrecte mot de passe'
            ];
        }
    }

    public function getDurations(Request $request)
    {   
        $date = $request->date;
        $groupe_id = $request->gp;
        $ids = [];
        $pass = false;

        $year = Absysyear::Where('active','on')->first()->year;
        $model = 'App\Models\Etat'.$year;

        $all =  $model::Where('date_abs',$date)->get();


        foreach ($all as $etat){
            if($etat->stagiaire->groupe_id == $groupe_id){
                $pass = true ;
                $id = $etat->duration_id;
                if($id == 1){
                    array_push($ids,1,2,3,4,5,6,7);
                    return false ;
                }
                if($id == 4 || $id == 5){
                    array_push($ids,$id,2);
                
                }else if($id == 6 || $id == 7){
                    array_push($ids,$id,3);

                }else if($id == 2){
                    array_push($ids,4,5,2);

                }else if($id == 3){
                    array_push($ids,6,7,3);
                }
            }
        }

        if(!$pass){
            return Duration::all()->where('active','on');
        }else{
            array_push($ids,1);
            return Duration::all()->whereNotIn('id',$ids)->where('active','on');
        }
    }

    public function getMostStAbs(Request $request){

        $id_gp = $request->id;
        $stagiaires = Stagiaire::where('groupe_id',$id_gp)->get();
        $id = 0;
        $hours = 0;
        foreach ( $stagiaires as $st ){
            if($st->heure_absence_st > $hours){
                $id = $st->id;
                $hours = $st->heure_absence_st;
            }
        }

        return [ 'id' => $id ];
        
    }

    public function updatePwdProfile(Request $request){
        
        $password = User::Find(Auth::user()->id)->password;

        if (Hash::check($request->password, $password)){

            $id = Auth::user()->id;

            User::Find($id)->update([
                'password' => $request->newPassword
            ]);

            return [
                'check' => true
            ];

        }else{
            return[
                'check' => false
            ];
        }
    }

    public function getFilhours(Request $request) 
    {
        $id = $request->id;
    
        $filHours = Stagiaire::with('groupe.filiere')->get()
        ->where("groupe.filiere.id","=",Groupe::Find($id)->filiere_id)
        ->where('heure_absence_st',"!=",0)->pluck('heure_absence_st')->sum();

        return [
            'Hours' => $filHours
        ];
    }
    
}
/* About carbon */
    // 'etat' => Stagiaire::find($this->id)->absences->where('etat_justif','NJ'),
    // 'start last week' => Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d'),
    // 'end last week' => Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d'),

    // 'start current week' => Carbon::now()->startOfWeek()->format('Y-m-d'),
    // 'end current week' => Carbon::now()->endOfWeek()->format('Y-m-d'),
    // 'timediff' => $timeOut->diffInMinutes($timeIn) / 60




    

