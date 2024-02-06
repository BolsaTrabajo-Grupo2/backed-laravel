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
        Schema::create('assigned', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idOffer');
            $table->unsignedBigInteger('idCycle');
            $table->foreign('idOffer', 'id_Offer')->references('id')->on('offers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('idCycle', 'idCycle')->references('id')->on('cycles')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned');
    }
};
