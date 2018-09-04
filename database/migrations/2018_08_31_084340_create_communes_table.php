<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('departement_id', 255)->nullable();
            $table->string('epci_id', 255)->nullable();
            $table->string('code_commune', 255)->nullable();
            $table->string('nom_commune', 255)->nullable(); 
            $table->string('code_region', 255)->nullable(); 
            $table->string('code_departement', 255)->nullable(); 
            $table->integer('siren_epci')->nullable();
            $table->integer('logements')->nullable();
            $table->integer('etablissements')->nullable(); 
            $table->string('zones_td', 255)->nullable(); 
            $table->string('engagements', 255)->nullable(); 
            $table->string('hors_engagements', 255)->nullable(); 
            $table->string('commune_rurale', 255)->nullable(); 
            $table->string('commune_montagne', 255)->nullable(); 
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
        Schema::dropIfExists('communes');
    }
}
