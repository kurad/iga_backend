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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->tinyInteger('is_admin')->default(0);
            $table->integer('school_id')->unsigned()->nullable();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};