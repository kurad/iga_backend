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
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('topic_title');
            $table->longText('instructional_objectives')->nullable();
            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('restrict')->onUpdate('cascade');
            $table->longText('topic_content')->nullable();
            $table->softDeletesTz();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};