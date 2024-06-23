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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id(); // Assuming you want an auto-incrementing primary key
            $table->string('client_name');
            $table->integer('store_matricule');
            $table->string('store_name');
            $table->string('store_address');
            $table->integer('period_location'); // Assuming period_locon in days, weeks, etc.
            $table->dateTime('rental_date');
            $table->decimal('price_store', 8, 2); // Assuming price_store can have decimals with up to 2 decimal places
            $table->foreign('store_matricule')->references('id')->on('stores');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
