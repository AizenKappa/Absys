<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etat extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];


    protected $with = ['prof','duration'];
    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }

    public function prof()
    {
        return $this->belongsTo(Prof::class);
    }
    public function duration()
    {
        return $this->belongsTo(Duration::class);
    }
    /* Etat::with('stagiaire','stagiaire.groupe')->first()->stagiaire->groupe->filiere_id */
}
