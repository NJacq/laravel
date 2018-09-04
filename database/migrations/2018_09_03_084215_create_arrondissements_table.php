<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrondissementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrondissements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('commune_id', 255)->nullable();
            $table->string('code_arrondissement', 255)->nullable();
            $table->string('nom_arrondissement', 255)->nullable(); 
            $table->string('code_region', 255)->nullable(); 
            $table->string('code_departement', 255)->nullable(); 
            $table->string('siren_epci', 255)->nullable(); 
            $table->string('code_commune', 255)->nullable();
            $table->integer('logements')->nullable();
            $table->integer('etablissements')->nullable(); 
            $table->string('zones_td', 255)->nullable(); 
            $table->string('oi_2018_t1', 255)->nullable();  
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
        Schema::dropIfExists('arrondissements');
    }
}
