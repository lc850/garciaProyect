<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cotizacion_id')->unsigned();
            $table->string('msg1', 800)->nullable();
            $table->string('msg2', 800)->nullable();
            $table->string('msg3', 800)->nullable();
            $table->string('msg4', 800)->nullable();
            $table->string('msg5', 800)->nullable();
            $table->timestamps();

            $table->foreign('cotizacion_id')
                ->references('id')->on('cotizaciones')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mensajes');
    }
}
