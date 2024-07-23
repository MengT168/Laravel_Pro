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
        Schema::create('set_sale_price', function (Blueprint $table) {
            $table->id();
            $table->integer('carId');
            $table->decimal('setSalePrice',10,2);
            $table->integer('authorId');
            $table->date('effectiveDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_sale_price');
    }
};
