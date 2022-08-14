
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
            
return new class extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('etat20212022s', function (Blueprint $table) {
            $table->id();
            $table->foreignId("stagiaire_id");
            $table->foreignId("prof_id");
            $table->foreignId("duration_id");
            $table->date("date_abs");
            $table->string("seance");
            $table->string("etat_justif")->default("NJ");
            $table->string("motif")->default("---");
            $table->timestamps();
        });
    }
            
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('etat20212022s');
    }
};
