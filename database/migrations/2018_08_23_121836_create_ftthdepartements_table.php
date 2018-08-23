<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFtthdepartementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ftthdepartements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code_departement', 255)->nullable(); // Création d'un champs texte de 255 caractères
            $table->integer('nombre_locaux')->nullable();
            $table->string('categorie', 255)->nullable();  
            $table->string('trimestre', 255)->nullable();  
            $table->string('annee', 255)->nullable();  
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
        Schema::drop('ftthdepartements');
    }
}
