<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Noten que usa el método "table" para editar la tabla.
        Schema::table('peliculas', function (Blueprint $table) {
            $table->unsignedSmallInteger('pais_id')->after('pelicula_id');

            // Definimos el campo como FK.
            $table->foreign('pais_id')->references('pais_id')->on('paises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peliculas', function (Blueprint $table) {
            $table->dropColumn('pais_id');
        });
    }
};
