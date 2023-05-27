<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('test_responses', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();;
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('unauthenticated_user_id')->nullable();
            $table->unsignedBigInteger('test_id');
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('test_id')->references('id')->on('tests');
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_responses');
    }
};
