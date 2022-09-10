<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Absysyear;
use App\Models\Groupe;
use Illuminate\Support\Facades\Auth;

class StagiaireResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $boolean = false;
        $id = $this->id;
        $nom_gp = Groupe::find($this->groupe_id)->nom_gp;

        $year = explode('-', Absysyear::Find(Auth::user()->year)->year);
        $year =  $year[0].$year[1];
        $Model = 'App\Models\Etat'.$year;


        $boolean = $Model::where(['stagiaire_id'=> $id,'etat_justif'=> 'NJ'])->count() > 0;
        


        return [
            'id' => $id,
            'nom_st'=> $this->nom_st,
            'prenom_st'=> $this->prenom_st,
            'leave' => $boolean,
            'nom_gp'=> $nom_gp

        ];
    }
}
