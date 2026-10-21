<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name');
            $table->string('contact_person');
            $table->string('email');
            $table->string('whatsapp');
            $table->string('social_link');
            $table->string('category');
            $table->string('photo_link');
            $table->text('description');
            $table->string('booth_size');
            $table->string('special_req')->nullable();
            $table->string('status')->default('pending'); // Untuk admin: pending, approved, rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};