<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCampanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campana', function (Blueprint $table) {
            $table->integer('cod_sede')->after('cod_programa');
            $table->integer('cod_metas')->after('cod_sede');
            $table->integer('cod_periodo')->after('cod_metas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campana', function (Blueprint $table) {
            $table->dropColumn('cod_sede');
            $table->dropColumn('cod_metas');
            $table->dropColumn('cod_periodo');
        });
    }
}
