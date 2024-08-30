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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('legal_name')->unique();
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('phone');
            $table->string('facsimile');
            $table->string('website');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_contact');
            $table->string('user_name')->nullable();
            $table->string('password');
            $table->string('type_company');
            $table->integer('status');
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
