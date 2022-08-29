<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Este método debe contener las instrucciones de los cambios que queremos aplicar a nuestra base de
     * datos.
     *
     * @return void
     */
    public function up()
    {
        // Para facilitar nuestro trabajo, Laravel nos brinda algunas calses:
        // 1. La "fachada" ("façade") "Schema", que contiene métodos para realizar cambios en el Schema
        //  de la base de datos.
        // 2. La clase "Blueprint" ("plano de construcción", en inglés) que permite configurar los
        //  cambios para una tabla.
        // Entre sus métodos, Schema tiene el método "create()" para crear una tabla, que recibe 2
        // parámetros:
        // 1. String. El nombre de la tabla.
        // 2. Closure. La función que contiene el código para la creación de la tabla. Este Closure recibe
        //  automáticamente un parámetro con la clase "Blueprint".
        Schema::create('peliculas', function (Blueprint $table) {
            /*
             * La tabla de peliculas va a tener los siguientes campos:
             * - pelicula_id            BIGINT ....
             * - titulo                 VARCHAR(60)     NOT NULL
             * - precio                 INT  UNSIGNED   NOT NULL
             * - fecha_estreno          DATE            NOT NULL
             * - descripcion            TEXT            NOT NULL
             * - portada                VARCHAR(255)    NULL
             * - portada_descripcion    VARCHAR(255)    NULL
             */

            // El método "id()" crea un campo que se llama por defecto "id" y tiene las características:
            //  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY_KEY
            // "id" es un nombre que usa por convención Laravel. Para saber cómo configurar esas
            // convenciones, nosotros vamos a usar otras.
            $table->id('pelicula_id');
            // Para definir un VARCHAR, usamos el método "string".
            // Todos los campos, por defecto, son NOT NULL, salvo que aclaremos lo contrario.
            $table->string('titulo', 60);
//            $table->integer('precio')->unsigned();
            $table->unsignedInteger('precio');
            $table->date('fecha_estreno');
            $table->text('descripcion');
            $table->string('portada', 255)->nullable();
            $table->string('portada_descripcion', 255)->nullable();

            // Además del método "id()", vemos que por defecto Laravel agrega un método "timestamps".
            // Este método crea dos columnas:
            // - created_at     TIMESTAMP
            // - updated_at     TIMESTAMP
            // Esos campos son manejados automáticamente si usamos el ORM de Laravel, "Eloquent".
            // Vamos a dejarlos.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Este método debe contener las instrucciones para deshacer los cambios realizados en el método up()
     * sobre la base de datos.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peliculas');
    }
};
