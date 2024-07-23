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
        Schema::create('car', function (Blueprint $table) {
            $table->id();
            $table->integer('modelId');
            $table->integer('colorId');
            $table->integer('categoryId');
            $table->string('year');
            $table->string('vin');
            $table->integer('mile');
            $table->string('condition');
            $table->string('status');
            $table->decimal('price', 10, 2);
            $table->integer('authorId');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car');
    }
};
