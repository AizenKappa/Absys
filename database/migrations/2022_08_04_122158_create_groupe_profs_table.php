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
        Schema::create('groupe_profs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prof_id');
            $table->foreignId('groupe_id');
            $table->string("year")->default(date("Y").'-'.((string)((int)date("Y"))+1));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupe_profs');
    }
};
