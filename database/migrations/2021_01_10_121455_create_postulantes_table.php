<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostulantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulante', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('email',250)->nullable();
            $table->string('tipo_documento',1)->nullable();
            $table->string('documento',25)->nullable();
            $table->bigInteger('etnia_id')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('sexo',1)->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('discapacidad')->nullable();
            $table->string('tipo_discapacidad')->nullable();
            $table->string('porcentaje_discapacidad')->nullable();
            $table->string('sector')->nullable();
            $table->string('direccion')->nullable();
            $table->string('provincia')->nullable();
            $table->string('canton')->nullable();
            $table->string('telefono',25)->nullable();
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
        Schema::dropIfExists('postulantes');
    }
}
