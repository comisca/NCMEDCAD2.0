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
        Schema::create('intitute_countries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('country_event_id')->unsigned();
            $table->bigInteger('events_id')->unsigned()->nullable();
            $table->bigInteger('intitute_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->decimal('qty', 20, 6);
            $table->decimal('price', 20, 6);
            $table->string('type_product', 100);
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intitute_countries');
    }
};
