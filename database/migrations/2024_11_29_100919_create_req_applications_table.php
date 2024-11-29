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
        Schema::create('req_applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('application_id')->unsigned();
            $table->bigInteger('requirement_id')->unsigned();
            $table->bigInteger('distribution_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('fabric_id')->unsigned();
            $table->text('message')->nullable();
            $table->integer('states_req_applications');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('req_applications');
    }
};
