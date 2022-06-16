<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('etats', function (Blueprint $table) {
            $table->id();
            $table->foreignId("stagiaire_id");
            $table->foreignId("filiere_id");
            $table->foreignId("prof_id");
            $table->date("date_abs");
            $table->time("h_debut");
            $table->time("h_fin");
            $table->string("seance");
            $table->string("etat_justif")->default("NJ");
            $table->string("motif")->default("---");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etats');
    }
};
