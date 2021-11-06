<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditoriaContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditoria_contactos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contacto_tipo_id');
            $table->bigInteger('accion_id')->nullable();
            /*$table->bigInteger('estado_comercial_id')->nullable();
            $table->bigInteger('fuente_contacto_id')->nullable();
            $table->bigInteger('medio_gestion_id')->nullable();*/
            $table->text('observacion')->nullable();
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
        Schema::dropIfExists('auditoria_contactos');
    }
}
