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
        Schema::create('stagiaires', function (Blueprint $table) {
            $table->id();
            $table->string("matricule_st");
            $table->string("nom_st");
            $table->string("prenom_st");
            $table->foreignId("groupe_id");
            $table->string("year")->default(date("Y").'-'.((string)((int)date("Y"))+1));
            $table->string("status")->default("Active");
            $table->float("heure_absence_st")->default(0);
            $table->string("numero_personnelle")->default("-----");
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stagiaires');
    }
};
