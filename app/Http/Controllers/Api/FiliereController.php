<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FiliereResource;
use App\Models\Etat;
use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\User;
use App\Models\Stagiaire;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPUnit\TextUI\XmlConfiguration\Group;

class FiliereController extends Controller
{

    public function index_filieres()
    {
        return FiliereResource::collection(Filiere::all());
    }

    public function index_stagiaires()
    {
        return Stagiaire::With('groupe')->get();
    }


    public function getgroupes(Request $request)
    {
        return FiliereResource::collection(Filiere::Find($request->id)->groupes);
    }


    public function getstagiaires(Request $request)
    {
        return FiliereResource::collection(Groupe::Find($request->id)->stagiaires);
    }


    public function getprofs(Request $request)
    {
        return FiliereResource::collection(Groupe::Find($request->id)->profs);
    }

    public function getetats(Request $request)
    {
        $id = $request->id;
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

        if($id == 'Tous')
            return FiliereResource::collection(Etat::whereBetween('date_abs', [$period_debut, $period_fin ])->get());
        else

        return FiliereResource::collection(Etat::with('stagiaire.groupe')->get()
            ->where('stagiaire.groupe.filiere_id',$id)
            ->whereBetween('date_abs',[$period_debut, $period_fin ]));

    }

    public function addUpAbsence(Request $request)
    {

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
    }

    public function addJustif(Request $request)
    {
       $absences_ids = $request->absences_ids;

       if($request->motif === "autre") $motif = $request->manualle_motif;
       else $motif = $request->motif;
       
       Etat::whereIn('id',$absences_ids)->update(['etat_justif' => 'J','motif' => $motif]);
    }

    public function getuser()
    {
        $user = User::Find(Auth::id()) ;
        return [
            'user_id' => $user->id,
            'cin' => $user->cin,
            'email' => $user->email,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
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

        }else{ return ['champ' => 'password', 'message' => 'wrong password']; }
       
    }

}
/* About carbon */
    // 'etat' => Stagiaire::find($this->id)->absences->where('etat_justif','NJ'),
    // 'start last week' => Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d'),
    // 'end last week' => Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d'),

    // 'start current week' => Carbon::now()->startOfWeek()->format('Y-m-d'),
    // 'end current week' => Carbon::now()->endOfWeek()->format('Y-m-d'),
    // 'timediff' => $timeOut->diffInMinutes($timeIn) / 60




    

