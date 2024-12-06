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
        Schema::create('notifications_applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('req_application_id')->unsigned()->nullable();
            $table->bigInteger('distribuidor_id')->unsigned();
            $table->text('message');
            $table->bigInteger('application_id')->unsigned()->nullable();
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications_applications');
    }
};
