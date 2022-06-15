<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FiliereResource;
use App\Models\Etat;
use App\Models\Filiere;
use App\Models\Groupe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

    public function index_etats(Request $request)
    {
        return FiliereResource::collection(Etat::all());
    }


}
