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
        Schema::create('peliculas_tienen_generos', function (Blueprint $table) {
            // Definimos las foreign keys.
            // Hay 2 maneras de hacerlo, la "común" (como la que hicimos con pais_id en la migration de
            // 'add_pais_id_column_to_peliculas_table'), y la "abreviada".
            // Usamos la forma abreviada para definir la FK con películas.
            // Nota: Esta forma solo sirve si la PK referenciada es UNSIGNED BIGINT.
            $table->foreignId('pelicula_id')->constrained('peliculas', 'pelicula_id');

            // Para la de géneros, como no es un BIGINT, lo hacemos de la forma tradicional.
            $table->unsignedTinyInteger('genero_id');
            $table->foreign('genero_id')->references('genero_id')->on('generos');

            // Definimos ambos campos como parte de la PK.
            $table->primary(['pelicula_id', 'genero_id']);

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
        Schema::dropIfExists('peliculas_tienen_generos');
    }
};
