<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangoWonderlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chango_wonderlist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('chango_id');
            $table->unsignedInteger('wonderlist_id');
            $table->integer('cantidad');
            $table->string('unidades')->default('unidad');
            $table->integer('subtotal');
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
        Schema::dropIfExists('chango_wonderlist');
    }
}
