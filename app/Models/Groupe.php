<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Groupe extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function profs()
    {
        return $this->belongsToMany(Prof::class,'relations');
    }

    public function stagiaires()
    {
        return $this->hasMany(Stagiaire::class);
    }
}
