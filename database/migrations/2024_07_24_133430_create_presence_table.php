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
        Schema::create('presence', function (Blueprint $table) {
            $table->id('presence_id');
            $table->unsignedBigInteger('employees_id');
            $table->date('presence_date');
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->string('picture_in')->nullable();
            $table->string('picture_out')->nullable();
            $table->enum('present_id', ['Masuk', 'Pulang', 'Tidak Hadir']); // Enum type for presence status
            $table->string('latitude_longtitude_in')->nullable();
            $table->string('latitude_longtitude_out')->nullable();
            $table->text('information')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('employees_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presence');
    }
};
