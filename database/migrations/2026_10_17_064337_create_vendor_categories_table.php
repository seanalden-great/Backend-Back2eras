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
        Schema::create('vendor_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "Retail", "F&B"
            $table->string('image_url'); // Contoh: Link gambar unsplash
            $table->string('subtitle')->nullable(); // Contoh: "Only open to:"
            $table->text('features'); // Contoh: "Fashion,Jewelry" (Nanti dipisah dengan koma)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_categories');
    }
};
