<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epci', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('departement_id')->nullable();
            $table->string('siren_epci', 255)->nullable();
            $table->string('nom_epci', 255)->nullable();
            $table->integer('logements')->nullable();
            $table->integer('etablissements')->nullable();
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
        Schema::dropIfExists('epci');
    }
}
