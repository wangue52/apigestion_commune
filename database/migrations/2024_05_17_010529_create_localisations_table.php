<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ForeignKeyDefinition;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('localisations', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id');
            $table->integer('longitude_id');
            $table->integer('latitude_id');
            $table->timestamps();
            $table->foreign('longitude_id')->references('longitude')->on('stores');
            $table->foreign('latitude_id')->references('latitude')->on('stores');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localisations');
    }
};
