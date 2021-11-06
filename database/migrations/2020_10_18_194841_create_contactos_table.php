<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',250)->nullable();
            $table->string('cedula',250)->nullable();
            $table->string('correo',250)->unique();
            $table->string('telefono',20)->nullable();
            $table->string('genero',100)->nullable();
            $table->string('direccion',250)->nullable();
            $table->bigInteger('procedencia_id')->nullable();
            $table->bigInteger('tipo_estudiante_id')->nullable();
            $table->char('estado',1)->default('A')->nullable();
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('contactos');
    }
}
