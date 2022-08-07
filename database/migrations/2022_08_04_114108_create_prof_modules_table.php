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
        Schema::create('prof_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->foreignId('prof_id')->references('id')->on('profs')->onDelete('cascade');
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
        Schema::dropIfExists('prof_modules');
    }
};
