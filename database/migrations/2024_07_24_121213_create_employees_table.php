<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employees_code')->unique();
            $table->string('employees_email')->unique();
            $table->string('employees_password');
            $table->string('employees_name');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('building_id');
            $table->string('photo')->nullable();
            $table->dateTime('created_login')->nullable();
            $table->string('created_cookies')->nullable();
            $table->timestamps();

            // // Foreign key constraints
            // $table->foreign('position_id')->references('id')->on('position')->onDelete('cascade');
            // $table->foreign('shift_id')->references('id')->on('shift')->onDelete('cascade');
            // $table->foreign('building_id')->references('id')->on('building')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
