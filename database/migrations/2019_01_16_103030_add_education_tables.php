<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEducationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('coefficient')->unsigned();

            $table->timestamps();
        });

        Schema::create('education_person', function (Blueprint $table) {
            $table->integer('person_id')->unsigned();
            $table->integer('education_id')->unsigned();

            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('education_id')->references('id')->on('educations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
