<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlcartedepartementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urlcartedepartements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('departement_id')->nullable(); // Création d'un champs texte de 255 caractères
            $table->string('code_departement', 255)->nullable(); // Création d'un champs texte de 255 caractères
            $table->string('url', 255)->nullable(); // Création d'un champs texte de 255 caractères
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
        Schema::dropIfExists('urlcartedepartements');
    }
}
