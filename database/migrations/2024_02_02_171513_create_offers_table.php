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
            $table->string('responsible_name',100);
            $table->boolean('inscription_method');
            $table->boolean('status')->default(1);
            $table->boolean('verified')->default(false);
            $table->string('observations',250)->nullable();
            $table->string('CIF',9)->nullable();
            $table->timestamps();
            $table->foreign('CIF', 'CIF')->references('CIF')->on('companies')->onDelete('restrict')->onUpdate('cascade');
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
