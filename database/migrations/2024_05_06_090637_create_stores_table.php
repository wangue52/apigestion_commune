<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id('number');
            $table->string('name');
            $table->unsignedBigInteger('bloc_id');
            $table->string('city');
            $table->string('district');
            $table->double('longitude');
            $table->double('latitude');
            $table->enum('status', ['disponible', 'indisponible']);
            $table->timestamps();

            $table->foreign('bloc_id')->references('id')->on('blocs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
