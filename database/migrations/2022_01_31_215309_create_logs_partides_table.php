<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsPartidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs_partides', function (Blueprint $table) {
            $table->id();
            $table->integer('id_partida');
            $table->integer('sessid');
            $table->text('moviment');
            $table->text('direccio');
            $table->integer('obstacle');
            $table->longtext('res');
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
        Schema::dropIfExists('logs_partides');
    }
}
