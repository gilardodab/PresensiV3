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
        Schema::create('cuty', function (Blueprint $table) {
            $table->id('cuty_id');
            $table->unsignedBigInteger('employees_id');
            $table->date('cuty_start');
            $table->date('cuty_end');
            $table->date('date_work');
            $table->integer('cuty_total');
            $table->text('cuty_description')->nullable();
            $table->string('cuty_status');
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
        Schema::dropIfExists('cuty');
    }
};
