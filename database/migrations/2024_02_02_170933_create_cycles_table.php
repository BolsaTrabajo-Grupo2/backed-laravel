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
        Schema::create('cycles', function (Blueprint $table) {
            $table->id();
            $table->string('cycle', 50);
            $table->string('title', 100)->nullable();
            $table->unsignedBigInteger('id_family');
            $table->unsignedBigInteger('id_responsible');
            $table->string('vliteral', 150);
            $table->string('cliteral', 150);
            $table->foreign('id_family', 'id_family')->references('id')->on('families')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_responsible', 'id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cycles');
    }
};
