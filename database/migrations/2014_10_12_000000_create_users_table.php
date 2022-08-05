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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('cin')->unique();
            $table->integer('formateur_id')->default(-1);
            $table->string('firstname');
            $table->string('lastname');
            $table->string('password');
            $table->string('email');
            $table->string('role')->default('Formateur');
            $table->string('picture_path')->default("undefindedUser.png");
            $table->integer('status')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
