<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFtthepciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ftthepci', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('epci_id')->nullable();
            $table->integer('departement_id')->nullable();
            $table->string('siren_epci', 255)->nullable(); // Création d'un champs texte de 255 caractères
            $table->integer('locaux_raccordables')->nullable();
            $table->integer('categorie')->nullable();  
            $table->integer('trimestre')->nullable();  
            $table->integer('annee')->nullable();  
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
        Schema::dropIfExists('ftthepci');
    }
}
