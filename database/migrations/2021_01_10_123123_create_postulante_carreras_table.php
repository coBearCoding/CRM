<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostulanteCarrerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulante_carreras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('postulante_id');

            $table->bigInteger('facultad_id')->nullable();
            $table->string('facultad_nombre',250)->nullable();

            $table->bigInteger('carrera_id')->nullable();
            $table->string('carrera_nombre',250)->nullable();

            $table->bigInteger('enfasis_id')->nullable();
            $table->string('enfasis_nombre',250)->nullable();

            $table->string('modalidad_id',250)->nullable();
            $table->string('modalidad_nombre',250)->nullable();

            $table->string('enteraste',250)->nullable();
            $table->text('porque_estudiaste')->nullable();

            $table->string('trabajando',2)->nullable();
            $table->string('empresa',250)->nullable();
            $table->string('cargo',250)->nullable();
            $table->string('telefono',25)->nullable();
            $table->string('ciudad',250)->nullable();
            $table->string('direccion',250)->nullable();

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
        Schema::dropIfExists('postulante_carreras');
    }
}
