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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table-> unsignedBigInteger('id_user');
            $table->string('address', 100);
            $table->string('cv_link', 75)->nullable();
            $table->boolean('accept')->default(0);
            $table->string('observations',250)->nullable();
            $table->timestamps();
            $table->foreign('id_user', 'id_usuario')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
