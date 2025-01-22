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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('event_id')->unsigned();
            $table->string('type_auction', 100);
            $table->string('type_product', 100);
            $table->string('auction_state');
            $table->string('auction_result');
            $table->decimal('total', 20, 6);
            $table->decimal('price_reference', 20, 6);
            $table->date('date_start');
            $table->time('hour_start');
            $table->integer('duration_time');
            $table->decimal('porcentage_reductions', 20, 6)->nullable();
            $table->decimal('porcentage_tolerance', 20, 6)->nullable();
            $table->integer('recovery_time')->nullable();
            $table->text('observation')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
