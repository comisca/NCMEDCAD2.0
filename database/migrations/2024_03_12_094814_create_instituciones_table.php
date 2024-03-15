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
        Schema::create('instituciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_pais');
            $table->foreign('id_pais')->references('id')->on('paises');
            $table->string('institucion',90)->nullable();
            $table->unsignedBigInteger('id_institucion_padre')->nullable();
            $table->foreign('id_institucion_padre')->references('id')->on('instituciones');
            $table->boolean('paga_cuota')->default(false);
            $table->boolean('cuota_pagada')->default(false);
            $table->boolean('es_minsa')->default(false);
            $table->string('encabezado_nota_cobro',2000)->nullable();
            $table->string('nombre_corto',50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instituciones');
    }
};
