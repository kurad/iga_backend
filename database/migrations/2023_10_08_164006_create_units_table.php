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
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unit_title');
            $table->string('key_unit_competence')->nullable();
            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('restrict')->onUpdate('cascade');
            $table->softDeletesTz();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};