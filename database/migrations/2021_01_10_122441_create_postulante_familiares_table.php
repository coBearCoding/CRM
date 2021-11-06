<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostulanteFamiliaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulante_familiares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('postulante_id');
            $table->string('nombre_padre',250)->nullable();
            $table->string('apellido_padre',250)->nullable();
            $table->string('email_padre',250)->nullable();
            $table->string('telefono_padre',250)->nullable();
            $table->string('empresa_padre',250)->nullable();
            $table->string('cargo_padre',250)->nullable();
            $table->string('direccion_padre',250)->nullable();
            $table->string('nivel_educacion_padre',250)->nullable();

            $table->string('nombre_madre',250)->nullable();
            $table->string('apellido_madre',250)->nullable();
            $table->string('email_madre',250)->nullable();
            $table->string('telefono_madre',250)->nullable();
            $table->string('empresa_madre',250)->nullable();
            $table->string('cargo_madre',250)->nullable();
            $table->string('direccion_madre',250)->nullable();
            $table->string('nivel_educacion_madre',250)->nullable();

            $table->bigInteger('cantidad_hermanos')->nullable();
            $table->string('edad_hermanos',250)->nullable();
            $table->string('emergencia',25)->nullable();
            $table->string('celular',25)->nullable();

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
        Schema::dropIfExists('postulante_familiares');
    }
}
