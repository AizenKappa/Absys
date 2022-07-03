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
use Illuminate\Support\Facades\Artisan;

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
                    'role' => $request->role,
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
            $user->role = $request->role;
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
            // $request->file('base')->storeAs('excels',"base.csv");
            // $request->file('avant')->storeAs('excels',"avant.csv");
        
       

            // $avantPath = storage_path('/app/excels/avant.csv');
            // $basePath= storage_path('/app/excels/base.csv');     
            // /* -------------------base-------------------- */
            // $array = [];
            // $handle = fopen($basePath, "r");
            // while (( $row = fgetcsv($handle)) !== false) {
            //     $array[] = $row;
            // }
            // $array = mb_convert_encoding($array, "UTF-8", "auto");
            // /* --------------------avant------------------------ */
            // $array_p = [];
            // $handle = fopen($avantPath, "r");
            // while (( $row = fgetcsv($handle)) !== false) {
            //     $array_p[] = $row;
            // }
            // $array_p = mb_convert_encoding($array_p, "UTF-8", "auto");
            /* Getting the extension */
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
            // return[
            //     "base"=>$baseExt,
            //     "avant"=>$avantExt,
            // ];
            
    
    
        return $this->readAndInsert($array, $array_p);

    }

    public function readAndInsert($array, $array_p)
    
    {
        // /*        ----------------------------------Filiere TABLE------------------------------------              */
        $filieres = [];
        $exFil=[];/* filiere that has been adde to $filiere */
        $i=1;
        foreach ($array as $e) {
        
            if (!in_array($e[4],$exFil) && preg_match('/EL HANK/', $e[2]))
            {
                array_push($filieres, [
                    "id" =>$i++,
                    "code_fil" => $e[4],
                    "nom_fil" => $e[5],
                ]);
                array_push($exFil,$e[4]);
            }
        }
        $txt = "INSERT INTO `filieres` (`code_fil`, `nom_fil`) VALUES \n\t\t";

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

        

        // /*--------------------------------------------------------------------------------------------------------------*/
        // /*            ----------------------------------GROUPES TABLE------------------------------------              */
        $groupes = [];
        $nom_grList = [];
        $i=1;
        foreach ($array as $e) {
            $nom_gr = $e[7];
            $code_fil = $e[4];
            if (!in_array($nom_gr, $nom_grList) && preg_match('/EL HANK/', $e[2]) && preg_match('/\w+/',$nom_gr))
            {
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
            && in_array($e[7], $nom_grList) ) 
            {
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
            if($x == $lenst)
            {
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
            if(!in_array($e[19],$id_fm) && $test)
            {
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
        foreach ($profs as $for)
        {
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

        // /* -------------------------------------------------------------------------------------------------------*/

        $insertFile = fopen(database_path("/sql/data.sql"),"w");
        fwrite($insertFile,$txt);
        

       Artisan::call('migrate:fresh --seed');
        return [
            "message"=> "success"
        ];
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

}
/* About carbon */
    // 'etat' => Stagiaire::find($this->id)->absences->where('etat_justif','NJ'),
    // 'start last week' => Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d'),
    // 'end last week' => Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d'),

    // 'start current week' => Carbon::now()->startOfWeek()->format('Y-m-d'),
    // 'end current week' => Carbon::now()->endOfWeek()->format('Y-m-d'),
    // 'timediff' => $timeOut->diffInMinutes($timeIn) / 60




    

