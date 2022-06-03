<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Filiere extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $guarded = [];

    public function groupes()
    {
        return $this->hasMany(Groupe::class);
    }
}
