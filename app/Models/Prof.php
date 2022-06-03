<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Prof extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function groupes()
    {
        return $this->belongsToMany(Groupe::class,'relations');
    }

    public function absences()
    {
        return $this->hasMany(Etat::class);
    }
}
