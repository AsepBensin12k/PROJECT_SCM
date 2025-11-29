<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();

            // 🔹 Tambahkan kode distribusi unik
            $table->string('code')->unique();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('destination');
            $table->integer('quantity');

            // 🔹 Pastikan enum lengkap
            $table->enum('status', ['diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('diproses');

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distributions');
    }
};
