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
            $table->string('code_departement', 11)->nullable(); 
            $table->integer('nombre_locaux')->nullable();
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
        Schema::dropIfExists('ftthdepartements');
    }
}
