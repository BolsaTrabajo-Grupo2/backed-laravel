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
            $table->unsignedBigInteger('id_offer');
            $table->unsignedBigInteger('id_student')->nullable();
            $table->foreign('id_offer', 'id_offer')->references('id')->on('offers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_student', 'idStudent')->references('id')->on('students')->onDelete('set null');
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
