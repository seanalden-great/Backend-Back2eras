<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email'); // Tidak dibuat unique agar bisa daftar berkali-kali untuk event berbeda
            $table->string('whatsapp');
            $table->string('instagram')->nullable();
            $table->boolean('subscribe_newsletter')->default(false); // Untuk opsi checkbox promosi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
