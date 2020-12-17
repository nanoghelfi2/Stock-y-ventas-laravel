<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('changos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('cliente_id')->default(1); // Relación Uno a muchos con cliente
            $table->string('estadoVenta')->default('proceso');
            $table->integer('descuento')->default(0);
            $table->string('lugarTemporal')->nullable();
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
        Schema::dropIfExists('changos');
    }
}
