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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('legal_name')->unique();
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('phone')->nullable();
            $table->string('phone_whatsapp')->nullable();
            $table->string('facsimile')->nullable();
            $table->string('website')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_contact')->nullable();
            $table->string('user_name')->nullable();
            $table->string('password')->nullable();
            $table->string('type_company');
            $table->string('logo_companies')->nullable();
            $table->bigInteger('country_id')->unsigned();
            $table->bigInteger('state_id')->unsigned();
            $table->integer('status');
            $table->bigInteger('family_id')->unsigned();
            $table->string('type_participante')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
