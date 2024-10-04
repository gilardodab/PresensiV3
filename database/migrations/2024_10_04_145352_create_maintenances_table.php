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
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employees_id');
            $table->unsignedBigInteger('id_customers');
            $table->string('kalibrasi_awal', 255);
            $table->string('noseri_mt', 191);
            $table->date('tgl_mt');
            $table->time('jam_mt');
            $table->string('ket_mt', 199)->nullable();
            $table->string('kalibrasi_mt', 11);
            $table->string('lokasi_mt', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
