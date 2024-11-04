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
        Schema::create('callplan', function (Blueprint $table) {
            $table->id('callplan_id');
            $table->unsignedBigInteger('employees_id');
            $table->date('tanggal_cp');
            $table->string('nama_outlet');
            $table->text('description')->nullable();
            $table->timestamps();

            // Jika ada relasi dengan tabel employees, tambahkan foreign key
            $table->foreign('employees_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('callplan');
    }
};
