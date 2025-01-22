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
        Schema::create('pujas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('auction_id')->unsigned();
            $table->bigInteger('postor_id')->unsigned();
            $table->decimal('amount', 20, 6);
            $table->datetime('puja_time');
            $table->integer('winner_puja')->default(0);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pujas');
    }
};
