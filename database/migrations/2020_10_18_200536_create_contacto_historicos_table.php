<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactoHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacto_historicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contacto_tipo_id');
            $table->bigInteger('fuente_contacto_id')->nullable();
            $table->bigInteger('campana_programa_id')->nullable();
            $table->bigInteger('otro_porgrama_id')->nullable();
            $table->bigInteger('estado_comercial_id')->nullable();
            $table->bigInteger('vendedor_id')->nullable();
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
        Schema::dropIfExists('contacto_historicos');
    }
}
