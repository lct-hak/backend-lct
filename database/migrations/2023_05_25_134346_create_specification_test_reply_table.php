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
        Schema::create('specification_test_reply', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specification_id')->constrained('specifications')->onDelete('cascade');
            $table->foreignId('test_reply_id')->constrained('test_replies')->onDelete('cascade');
            // Добавьте другие необходимые поля для pivot таблицы
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specification_test_reply');
    }
};
