<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('contact_person');
            $table->string('email');
            $table->string('whatsapp');
            $table->string('social_link');
            $table->string('interest');
            $table->text('idea');
            $table->string('budget')->nullable();
            $table->string('deck_link')->nullable();
            $table->string('status')->default('pending'); // Untuk admin: pending, reviewed, approved, rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};