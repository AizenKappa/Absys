<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FiliereResource;
use App\Models\Etat;
use App\Models\Filiere;
use App\Models\Groupe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use PHPUnit\TextUI\XmlConfiguration\Group;

class FiliereController extends Controller
{

    public function index_filieres()
    {
        return FiliereResource::collection(Filiere::all());
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
            Etat::with('stagiaire.groupe')->get()
            ->where('stagiaire.groupe.filiere_id',$id)
            ->whereBetween('date_abs',[$period_debut, $period_fin ]);

    }

}
/* About carbon */
    // 'etat' => Stagiaire::find($this->id)->absences->where('etat_justif','NJ'),
    // 'start last week' => Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d'),
    // 'end last week' => Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d'),

    // 'start current week' => Carbon::now()->startOfWeek()->format('Y-m-d'),
    // 'end current week' => Carbon::now()->endOfWeek()->format('Y-m-d'),
    // 'timediff' => $timeOut->diffInMinutes($timeIn) / 60




    

