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
        Schema::create('grupos_requisitos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_familia_producto');
            $table->foreign('id_familia_producto')->references('id')->on('familia_producto');
            $table->string('grupo',200)->nullable();
            $table->smallInteger('orden')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('grupos_requisitos');
    }
};
