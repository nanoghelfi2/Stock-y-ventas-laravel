<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWonderlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wonderlists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('marca');
            $table->string('tipo');
            $table->integer('precioCompra')->nullable();
            $table->string('unidadCompra')->nullable();
            $table->integer('precioVenta')->nullable();
            $table->integer('precioPack')->nullable();
            $table->integer('stock')->nullable();
            $table->string('tipoCerveza')->nullable();
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
        Schema::dropIfExists('wonderlists');
    }
}
