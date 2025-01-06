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
        Schema::create('document_applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('req_application_id')->unsigned();
            $table->string('document_name');
            $table->string('attachment');
            $table->text('descriptions')->nullable();
            $table->string('name_table')->nullable();
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_applications');
    }
};
