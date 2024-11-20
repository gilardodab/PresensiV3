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
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id('kunjungan_id');
            $table->unsignedBigInteger('employees_id');
            $table->date('kunjungan_tgl');
            $table->time('time_in');
            $table->string('picture_in')->nullable(); 
            $table->string('status_kunjungan');
            $table->string('latitude_longtitude_in')->nullable();
            $table->text('information')->nullable();
            $table->unsignedBigInteger('callplan_id')->nullable(); 
            $table->text('description')->nullable();
            $table->timestamps();

            // Relasi jika tabel employees 
            $table->foreign('employees_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('callplan_id')->references('callplan_id')->on('callplan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};
