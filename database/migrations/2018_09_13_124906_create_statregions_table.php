<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatregionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statregions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('region_id')->nullable();
            $table->integer('trimestre_debut')->nullable();
            $table->integer('annee_debut')->nullable();
            $table->integer('trimestre_fin')->nullable();
            $table->integer('annee_fin')->nullable();
            $table->integer('nb_locaux_debut')->nullable();
            $table->integer('nb_locaux_fin')->nullable();
            $table->integer('pourcentage_progression')->nullable();
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
        Schema::dropIfExists('statregions');
    }
}
