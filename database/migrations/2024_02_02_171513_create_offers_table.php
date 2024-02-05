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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('description',200);
            $table->string('duration',50);
            $table->string('responsibleName',100);
            $table->boolean('inscriptionMethod');
            $table->boolean('status');
            $table->string('cif',9);
            $table->foreign('cif', 'cif')->references('CIF')->on('company')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
