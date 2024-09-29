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
            $table->id('user_id');
            $table->string('username', 40);
            $table->string('email', 50);
            $table->string('password', 100);
            $table->string('fullname', 40);
            $table->dateTime('registered');
            $table->dateTime('created_login')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('session', 100)->nullable();
            $table->string('ip', 20)->nullable();
            $table->string('browser', 30)->nullable();
            $table->integer('level');
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
