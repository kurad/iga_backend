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
        Schema::create('topic_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('topic_id')->unsigned();
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('restrict')->onUpdate('cascade');
            $table->string('question')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->softDeletesTz();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_questions');
    }
};