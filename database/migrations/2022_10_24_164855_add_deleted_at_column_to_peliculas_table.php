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
        Schema::table('peliculas', function (Blueprint $table) {
            // La idea es agregar un campo que sirva para marcar como "deshabilitado" o "eliminado" un
            // registro, para poder conservarlos en vez de eliminarlos físicamente de la tabla.
            // En Laravel, este campo suele llamarse "deleted_at" y ser de tipo TIMESTAMP NULL.
            // La idea es que sí el valor es "null", el registro no está eliminado. Si no es null,
            // entonces está eliminado, y el valor es la fecha de eliminación.
            // Como es de esperarse, Eloquent tiene la posibilidad de utilizar "Soft Deletes" en vez de
            // eliminar físicamente los registros. Y por lo tanto, también tenemos un campo especial en
            // las migraciones para definir la columna que mencionamos:
            $table->softDeletes();
            $table->index('deleted_at'); // Si usamos Soft Deletes, es esencial que estén indexados.
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
            $table->dropSoftDeletes();
        });
    }
};
