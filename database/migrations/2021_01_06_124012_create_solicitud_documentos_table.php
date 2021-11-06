<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_documentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->bigInteger('solicitud_id')->nullable();
            $table->bigInteger('documento_id')->nullable();
            $table->string('estado',1)->nullable();
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
        Schema::dropIfExists('solicitud_documentos');
    }
}
