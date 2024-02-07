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
        Schema::create('applies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idOffer');
            $table->unsignedBigInteger('idStudent');
            $table->foreign('idOffer', 'idOffer')->references('id')->on('offers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('idStudent', 'idStudent')->references('id')->on('students')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applies');
    }
};
