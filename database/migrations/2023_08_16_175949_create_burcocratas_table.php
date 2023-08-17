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
        Schema::create('burcocratas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_contratacion');
            $table->unsignedBigInteger('puesto_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('puesto_id')->references('id')->on('puestos');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('burcocratas');
    }
};
