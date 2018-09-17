<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFtthregionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ftthregions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('region_id')->nullable();
            $table->string('code_region', 255)->nullable(); // Création d'un champs texte de 255 caractères
            $table->integer('nombre_locaux')->nullable();
            $table->integer('categorie')->nullable();  
            $table->string('unoperateur', 255)->nullable();  
            $table->string('deuxoperateurs', 255)->nullable();  
            $table->string('troisoperateurs', 255)->nullable();  
            $table->string('quatreoperateurs', 255)->nullable();  
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
        Schema::dropIfExists('ftthregions');
    }
}
