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
        Schema::create('test_reply_test_response', function (Blueprint $table) {
            $table->unsignedBigInteger('test_reply_id');
            $table->unsignedBigInteger('test_response_id');

            $table->foreign('test_reply_id')->references('id')->on('test_replies')->onDelete('cascade');
            $table->foreign('test_response_id')->references('id')->on('test_responses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_reply_test_response');
    }
};
