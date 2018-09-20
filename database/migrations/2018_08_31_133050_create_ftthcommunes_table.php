<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFtthcommunesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ftthcommunes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commune_id')->nullable();
            $table->integer('departement_id')->nullable();
            $table->integer('epci_id')->nullable();            
            $table->string('code_commune', 255)->nullable(); 
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
        Schema::dropIfExists('ftthcommunes');
    }
}
