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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('family_id')->unsigned();
            $table->bigInteger('requirement_id')->unsigned()->nullable();
            $table->bigInteger('distribution_id')->unsigned();
            $table->bigInteger('fabric_id')->unsigned();
            $table->bigInteger('country_id')->unsigned();
            $table->string('trade_name');
            $table->string('number_registration_salud');
            $table->string('number_registration_fabric');
            $table->text('message')->nullable();
            $table->integer('states_applications');
            $table->integer('calification_tec')->default(0);
            $table->integer('calification_admin')->default(0);
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
