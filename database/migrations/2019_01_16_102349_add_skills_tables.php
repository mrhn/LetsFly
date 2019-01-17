<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSkillsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('person_skill', function (Blueprint $table) {
            $table->integer('person_id')->unsigned();
            $table->integer('skill_id')->unsigned();

            $table->foreign('person_id')->references('id')->on('people');
            $table->foreign('skill_id')->references('id')->on('skills');

            $table->float('coefficient');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_skill');
        Schema::dropIfExists('skills');
    }
}
