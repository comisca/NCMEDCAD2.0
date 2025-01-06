<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requisitos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_familia_producto')->unsigned();
            $table->bigInteger('grupo_requisito_id')->unsigned();
            $table->string('tipo_requisitos', 200);
            $table->string('codigo', 200);
            $table->string('tipo_participante', 200);
            $table->string('tipo_validacion', 200);
            $table->text('descripcion');
            $table->text('mensaje_nocumple');
            $table->integer('obligatorio');
            $table->integer('status')->default(1);
            $table->integer('ficha')->default(0);
            $table->integer('entregable')->default(0);
            $table->integer('vence')->default(0);
            $table->date('date_vence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisitos');
    }
};
