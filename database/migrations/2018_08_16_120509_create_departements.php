<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('region_id')->nullable();
            $table->string('epci_id')->nullable();
            $table->string('code_departement', 255)->nullable(); // Création d'un champs texte de 255 caractères
            $table->string('nom_departement', 255)->nullable(); 
            $table->string('code_region', 255)->nullable(); 
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
        Schema::drop('departements');
    }
}
