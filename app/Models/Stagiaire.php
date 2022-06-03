<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    
    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function absences()
    {
        return $this->hasMany(Etat::class);
    }
    
}
