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
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->boolean('school_status')->default(1);
            $table->integer('sector_id')->unsigned();
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};