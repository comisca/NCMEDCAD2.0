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
        Schema::create('req_relation_profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('req_id')->unsigned();
            $table->bigInteger('profile_id')->unsigned()->nullable();
            $table->bigInteger('application_id')->unsigned();
            $table->string('type_profile');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('req_relation_profiles');
    }
};
