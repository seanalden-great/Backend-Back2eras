<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('media_name');
            $table->string('contact_person');
            $table->string('email');
            $table->string('whatsapp');
            $table->string('social_links');
            $table->string('media_category');
            $table->string('audience_size')->nullable();
            $table->string('media_kit');
            $table->text('coverage_format');
            $table->string('status')->default('pending'); // Untuk admin: pending, approved, rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};