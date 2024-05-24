<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('taxe_id');
            $table->integer('userId');
            $table->enum('status', ['payer', 'nom payer']);
            $table->datetimes('validity_duration');
            $table->timestamps();
            $table->foreign('taxe_id')->references('id')->on('type_taxes');
            $table->foreign('userId')->references('id')->on('users');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxes');
    }
};
