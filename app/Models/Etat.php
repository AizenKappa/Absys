<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etat extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }

    public function prof()
    {
        return $this->belongsTo(Prof::class);
    }

}
