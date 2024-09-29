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
        Schema::create('building', function (Blueprint $table) {
            $table->id('building_id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('address');
            $table->string('latitude_longtitude');
            $table->decimal('radius', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('building');
    }
};
