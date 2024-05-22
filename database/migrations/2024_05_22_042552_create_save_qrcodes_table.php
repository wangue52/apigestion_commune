<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('save_qrcodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('storeId');
            $table->string('QRcodeImage')->nullable() ;
            $table->string('key')->unique();
            $table->timestamps();
            $table->foreign('storeId')->references('id')->on('stores') ;

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('save_qrcodes');
    }
};
