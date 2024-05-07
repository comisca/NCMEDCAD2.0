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
        Schema::create('paises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_pais',10);
            $table->string('pais',50);
            $table->boolean('es_sica')->default(false);
            $table->unsignedBigInteger('id_moneda')->nullable();
            $table->foreign('id_moneda')->references('id')->on('monedas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('paises');
    }
};
