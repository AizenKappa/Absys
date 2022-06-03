<?php

namespace App\Http\Livewire;

use App\Models\Filiere;
use Livewire\Component;

class Fildrop extends Component
{
    
    public function render()
    {
        $filiere = Filiere::all()->first()->get();
        return view('livewire.fildrop',[
            "fil"=>$filiere
        ]);
    }
}
