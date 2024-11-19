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
        Schema::create('documents_tables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('document_id')->unsigned();
            $table->string('table_name');
            $table->bigInteger('table_id')->unsigned();
            $table->string('document_name');
            $table->string('attachment');
            $table->string('ext_document')->nullable();
            $table->string('size_document')->nullable();
            $table->string('img_front')->nullable();
            $table->string('img_back')->nullable();
            $table->string('img_selfie')->nullable();
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_tables');
    }
};
