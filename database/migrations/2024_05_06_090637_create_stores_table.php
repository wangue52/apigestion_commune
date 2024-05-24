<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up():void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('matricule')->nullable();
            $table->unsignedBigInteger('bloc_id');
            $table->string('city');
            $table->string('district');
            $table->double('longitude');
            $table->double('latitude');
            $table->enum('status', [ 'indisponible', 'disponible' , 'renovations'])->default('indisponible');
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
        Schema::dropIfExists('stores');
    }
};
