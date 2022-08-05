<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupeModule extends Model
{
    use HasFactory;

    protected $table = 'groupe_modules';
    public $timestamps = false;
    protected $guarded = [];
}
