<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactoSeguimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacto_seguimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contacto_tipo_id');
            $table->bigInteger('estado_comercial_id')->nullable();
            $table->bigInteger('medio_gestion_id')->nullable();
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
        Schema::dropIfExists('contacto_seguimientos');
    }
}
