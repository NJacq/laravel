<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatcommunesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statcommunes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commune_id')->nullable();
            $table->integer('epci_id')->nullable();
            $table->integer('departement_id')->nullable();
            $table->integer('trimestre_debut')->nullable();
            $table->integer('annee_debut')->nullable();
            $table->integer('trimestre_fin')->nullable();
            $table->integer('annee_fin')->nullable();
            $table->integer('nb_locaux_debut')->nullable();
            $table->integer('nb_locaux_fin')->nullable();
            $table->string('pourcentage_progression', 11)->nullable();
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
        Schema::dropIfExists('statcommunes');
    }
}
