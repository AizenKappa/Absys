<?php

namespace App\Http\Livewire;

use App\Models\Filiere;
use App\Models\Groupe;
use Livewire\Component;

class GroupeDrop extends Component
{
    /* public $test="hello"; */
    public $currentGroupes="null";
    protected $listeners = ['getGroupe' => 'test'];
    public function render()
    {
        return view('livewire.groupe-drop',[
            "groupes" => $this->currentGroupes
        ]);
    }

    public function test($fil_id){
        $this->currentGroupes = Filiere::find($fil_id)->groupes->pluck("nom_gp");
        
    }
}
