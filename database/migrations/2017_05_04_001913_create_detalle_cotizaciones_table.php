<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleCotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_cotizaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cotizacion')->unsigned();
            $table->integer('id_grupo')->unsigned();
            $table->integer('id_material')->unsigned();
            $table->integer('cantidad');
            $table->double('precio');
            $table->timestamps();

            $table->foreign('id_cotizacion')
                ->references('id')->on('cotizaciones')
                ->onDelete('cascade');

            $table->foreign('id_grupo')
                ->references('id')->on('grupos')
                ->onDelete('cascade');

            $table->foreign('id_material')
                ->references('id')->on('materiales')
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
        Schema::drop('detalle_cotizaciones');
    }
}
