<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FiliereResource;
use App\Models\Duration;
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
use Intervention\Image\ImageManagerStatic as Image;

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

    public function index_users()
    {

        return FiliereResource::collection(User::all());
    }

    public function userById(Request $request) {

        $user = User::Find($request->id) ;
        return [
            'user_id' => $user->id,
            'cin' => $user->cin,
            'email' => $user->email,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
        ];

    }

    public function editThisUser (Request $request){

        $password = User::Find(Auth::user()->id)->password;

        if (Hash::check($request->password, $password)){


            $cin = $request->cin;
            $email = $request->email;

            if($cin != null){
                $search1 = User::Where('cin',$cin)->count();
                if($search1 > 0) { return ['champ' => 'cin' ,'message' => 'Cin existe déja']; }
            }else{
                $cin = User::Find($request->id)->cin;
            }


            if($email != null){
                $search2 = User::Where('email',$request->email)->count();
                if($search2 > 0) { return ['champ' => 'email' ,'message' => 'Cet E-mail déja existe']; }
            }else{
                $email = User::Find($request->id)->email;
            }
            

                User::Find($request->id)->update([
                    'firstname' => $request->first,
                    'lastname' => $request->last,
                    'cin' => $cin,
                    'email' => $email
                ]);

            
            return [
                'message' => 'user edited successe'
                
            ];
        }else{

            return [
                'champ' => 'password',
                'message' => 'Incorrecte mot de passe'
                
            ];
        }
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
        $duration_id = $request->duration_id;
        $seance = $request->seance;
        $date_abs = $request->date_abs;
       
        $dura = Duration::find($duration_id);
       
        $startTime = Carbon::parse($dura->h_debut);
        $endTime = Carbon::parse($dura->h_fin);
        $hours = $endTime->diffInMinutes($startTime)/60;
        foreach ($stagiaire_ids as $v) {
            Etat::create([
                "stagiaire_id" => $v,
                "prof_id" => $prof_id,
                "date_abs" =>$date_abs ?? Carbon::now() ,
                "duration_id"=>$duration_id,
                "seance" => $seance
            ]);
            
            $currentAbsence = Stagiaire::find($v)->heure_absence_st;
    
            Stagiaire::Where('id', $v)->update(['heure_absence_st' => ($currentAbsence + $hours)]);
        }

        return "This is Working ";
      
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
       $absences_ids = $request->absences_ids;

       if($request->motif === "autre") $motif = $request->manualle_motif;
       else $motif = $request->motif;
       
       Etat::whereIn('id',$absences_ids)->update(['etat_justif' => 'J','motif' => $motif]);
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
    

}
/* About carbon */
    // 'etat' => Stagiaire::find($this->id)->absences->where('etat_justif','NJ'),
    // 'start last week' => Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d'),
    // 'end last week' => Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d'),

    // 'start current week' => Carbon::now()->startOfWeek()->format('Y-m-d'),
    // 'end current week' => Carbon::now()->endOfWeek()->format('Y-m-d'),
    // 'timediff' => $timeOut->diffInMinutes($timeIn) / 60




    

