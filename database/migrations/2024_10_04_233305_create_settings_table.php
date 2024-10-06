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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_url', 100);
            $table->string('site_name', 50);
            $table->string('site_company', 30);
            $table->string('site_manager', 30)->nullable();
            $table->string('site_director', 30)->nullable();
            $table->char('site_phone', 12)->nullable();
            $table->text('site_address')->nullable();
            $table->text('site_description')->nullable();
            $table->string('site_logo', 50)->nullable();
            $table->string('site_email', 30)->nullable();
            $table->string('site_email_domain', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
