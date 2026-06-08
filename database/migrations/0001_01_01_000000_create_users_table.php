<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Kolom tambahan untuk BPRS
            $table->enum('role', ['admin', 'karyawan'])->default('karyawan');
            $table->enum('cabang', ['Pematangsiantar', 'Sidamanik', 'Perdagangan', 'Kisaran', 'Stabat']);
            $table->string('posisi')->default('Cabang');
            $table->string('fb_url')->nullable();
            $table->string('ig_url')->nullable();
            $table->string('wa_number')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};