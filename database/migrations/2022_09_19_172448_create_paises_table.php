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
        Schema::create('paises', function (Blueprint $table) {
//            $table->id();
            // Cambiamos la PK para que use un "SMALLINT" en vez de "BIGINT".
            $table->smallIncrements('pais_id');
            $table->string('nombre', 125);
            $table->char('abreviatura', 3)->comment('Por ejemplo: ARG, BRA, etc');
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
        Schema::dropIfExists('paises');
    }
};
