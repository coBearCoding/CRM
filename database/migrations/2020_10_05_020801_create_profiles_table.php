<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('telefono',15)->nullable();
            $table->string('celular',15)->nullable();
            $table->string('extension',15)->nullable();
            $table->string('tipo_llamada',20)->nullable();
            $table->string('numero_llamada',20)->nullable();
            $table->string('usuario_llamada',250)->nullable();
            $table->bigInteger('id_usuario_llamada')->nullable();
            $table->string('hora_llamada_usuario',200)->nullable();
            $table->string('tabla',200)->nullable();
            $table->bigInteger('id_call')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
