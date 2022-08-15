<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

use App\Http\Controllers\Api\FiliereController;
use App\Models\Groupe;
use App\Models\Stagiaire;
use PHPUnit\TextUI\XmlConfiguration\Group;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Settings;
class PrintController extends Controller
{
    public function loadStagPdf(Request $request,FiliereController $fil)
    {

        $data = $fil->StagInfo(intval($request->stag_id));
        $pdf = Pdf::loadView('pdfs.stagPdf',compact("data"));
        // return $pdf->stream($data["stFullName"].rand(1,50).'.pdf');
        return Response($pdf->output(),200,[
            'Content-Type' => 'application/pdf',
        ]);        
       
    }
    public function loadSearchPdf(Request $request)
    {   
        
        $absences = $request->absence;
        $nom_fil = $request->fil;
        $groupe = $request->groupe;
        $houreType = $request->houreType;
        $period = $request->period;
        $data = [
            "nom_fil" => $nom_fil,
            "absences"=>$absences,
            "groupe"=>$groupe,
            "period"=>$period,
            "houreType"=>$houreType
        ];
        $pdf = Pdf::loadView('pdfs.datePdf',compact("data"));
        return Response($pdf->output(),200,[
            'Content-Type' => 'application/pdf',
        ]);
       
    }
    public function loadPresencePdf(Request $request){
        $groupe_id_arr = $request->groupes;
        $type= $request->type;
        $DR = "DRCS";
        $anneeScolaire = "2021-2022";
        $complexe = "CF ANFA";
        $institut = "ISTA EL HANK CASABLANCA";
        $data = [];
        foreach($groupe_id_arr as $groupe_id){
            $groupe = Groupe::with('filiere')->where('id',$groupe_id)->get()[0];
            $niveau = $groupe->filiere->niveau;
            $nom_fil = $groupe->filiere->nom_fil;
            $nom_gp = $groupe->nom_gp;
           
            $stagiaires = Groupe::find($groupe_id)->stagiaires->map(function($item){
                return $item->only("id","nom_st","prenom_st");
            });
            $nbre=$stagiaires->count();
            array_push($data,[
                "anneeScolaire"=>$anneeScolaire,
                "type"=>$type,
                "dr"=>$DR,
                "complexe"=>$complexe,
                "institut"=>$institut,
                "niveau"=>$niveau,
                "filiere"=>$nom_fil,
                "groupe"=>$nom_gp,
                "nbre"=>$nbre,
                "stagiaires"=>$stagiaires
            ]);
        }
    
       
        // $tempPath= public_path("temps/Feuille_de_Presence.docx");
        // $templateProcessor = new TemplateProcessor($tempPath);
        
        // $templateProcessor->cloneRowAndSetValues('id', $stagiaires);

        // $pathToSave = public_path("/prints/anas.docx");
        // $templateProcessor->saveAs($pathToSave);
        // return "done";
        
        $pdf = Pdf::loadView('pdfs.presence',compact("data"));
        return Response($pdf->output(),200,[
            'Content-Type' => 'application/pdf',
        ]);
    }
    public function envParModule(Request $request)
    {
        $big_modules_id= $request->modules;
        $modules = [];
        foreach($big_modules_id as $md){
            $mod = Module::find($md);
            $code_mod = explode("_",$mod->code_mod);
            $module = $code_mod[0];
            $gp = $code_mod[1];
            $filiere_id = Groupe::where("nom_gp","like",$gp)->get()[0]["filiere_id"];
            $groupes = Filiere::find($filiere_id)->groupes->pluck("nom_gp");
            foreach($groupes as $gp){
                array_push($modules,$module."_".$gp);
            }
        }
        
        $data = Relation::with("groupe.filiere")->get()->whereIn("module.code_mod",$modules);
        
        
    
    
        $pdf = Pdf::loadView('pdfs.env',compact("data"));
        return Response($pdf->output(),200,[
            'Content-Type' => 'application/pdf',
        ]);
    }
    public function envParProf(Request $request)
    {
        $profs = $request->profs;
        $data  = Relation::with("groupe.filiere")->whereIn('prof_id',$profs)->get()->unique("module_id");
        
        // return $data;
        $pdf = Pdf::loadView('pdfs.env',compact("data"));
        return Response($pdf->output(),200,[
            'Content-Type' => 'application/pdf',
        ]);
    }
    public function testpdf(Request $request)
    {
        $pdf = PDF::loadview('pdfs.test');
        /* return $pdf->download('test.pdf'); */
        return Response($pdf->output(),200,['Content-Type' => 'application/pdf']);
    }
}
