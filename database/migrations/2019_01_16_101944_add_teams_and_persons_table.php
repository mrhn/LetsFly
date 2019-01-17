<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeamsAndPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('priority');

            $table->timestamps();
        });

        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('experience');

            $table->timestamps();
        });

        Schema::create('person_team', function (Blueprint $table) {
            $table->integer('person_id')->unsigned();
            $table->integer('team_id')->unsigned();

            $table->foreign('person_id')->references('id')->on('people');
            $table->foreign('team_id')->references('id')->on('teams');

            $table->string('skill');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
        Schema::dropIfExists('people');
    }
}
