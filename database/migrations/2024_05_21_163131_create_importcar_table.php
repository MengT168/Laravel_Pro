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
        Schema::create('importcar', function (Blueprint $table) {
            $table->id();
            $table->integer('carId');
            $table->dateTime('importDate');
            $table->decimal('importPrice',10,2);
            $table->integer('authorId');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('importcar');
    }
};
