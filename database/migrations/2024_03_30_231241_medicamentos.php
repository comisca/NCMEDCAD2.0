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
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_familia_producto')->nullable();
            $table->foreign('id_familia_producto')->references('id')->on('familia_producto');
            $table->unsignedBigInteger('id_grupo_familia')->nullable();
            $table->foreign('id_grupo_familia')->references('id')->on('grupos_productos');
            $table->unsignedBigInteger('id_grupo_requerimiento')->nullable();
            $table->foreign('id_grupo_requerimiento')->references('id')->on('grupos_requisitos');
            $table->string('cod_medicamento',15);
            $table->string('descripcion',400);
            $table->boolean('requiere_cadena_frio')->nullable();
            $table->boolean('activo')->default(false)->nullable();
            $table->string('observacion',1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('medicamentos');
    }
};
