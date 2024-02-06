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
        Schema::create('companies', function (Blueprint $table) {
            $table->string('CIF', 9);
            $table->unsignedBigInteger('id_user');
            $table->string('address', 100);
            $table->string('phone', 9);
            $table->string('web', 100)->nullable();
            $table->timestamps();
            $table->primary('CIF');
            $table->foreign('id_user', 'id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company');
    }
};
