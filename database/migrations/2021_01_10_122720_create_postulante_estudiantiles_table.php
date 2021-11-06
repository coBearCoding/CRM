<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostulanteEstudiantilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulante_estudiantiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('postulante_id');
            $table->bigInteger('tipo_institucion_id')->nullable();
            $table->string('tipo_institucion_nombre',250)->nullable();
            $table->string('institucion_id',250)->nullable();
            $table->string('institucion_nombre',250)->nullable();
            $table->string('jornada',250)->nullable();
            $table->string('graduacion',10)->nullable();
            $table->string('provincia',250)->nullable();
                      
            $table->string('estudio_superior',4)->nullable();
            $table->bigInteger('estudio_tipo_institucion_id')->nullable();
            $table->string('estudio_tipo_institucion_nombre')->nullable();
            $table->string('estudio_provincia',250)->nullable();
            $table->string('estudio_institucion_id',250)->nullable();
            $table->string('estudio_institucion_nombre',250)->nullable();
            $table->string('beca',25)->nullable();

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
        Schema::dropIfExists('postulante_estudiantiles');
    }
}
