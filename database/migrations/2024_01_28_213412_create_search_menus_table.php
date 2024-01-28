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
        Schema::create('search_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('route');
            $table->string('icon');
            $table->string('description')->nullable();
            $table->string('type');
            $table->string('status');
            $table->string('parent')->nullable();
            $table->string('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_menus');
    }
};
