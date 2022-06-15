<?php

namespace App\Http\Resources;

use App\Models\Groupe;
use App\Models\Stagiaire;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use PHPUnit\TextUI\XmlConfiguration\Group;

class FiliereResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        $timeIn = Carbon::parse('9:30:00');
        $timeOut = Carbon::parse('12:00:00');


        if($this->nom_st !== null){
            $nom_gp = Groupe::find($this->groupe_id)->nom_gp;
            return [
                'id' => $this->id,
                'nom_st'=> $this->nom_st,
                'prenom_st'=> $this->prenom_st,
                'nom_gp'=> $nom_gp,
            ];
        }

        if($this->etat_justif !== null){
            return parent::toArray($request);
        }
        return parent::toArray($request);

    }
}
/* About carbon */
    // 'etat' => Stagiaire::find($this->id)->absences->where('etat_justif','NJ'),
    // 'start last week' => Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d'),
    // 'end last week' => Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d'),

    // 'start current week' => Carbon::now()->startOfWeek()->format('Y-m-d'),
    // 'end current week' => Carbon::now()->endOfWeek()->format('Y-m-d'),
    // 'timediff' => $timeOut->diffInMinutes($timeIn) / 60