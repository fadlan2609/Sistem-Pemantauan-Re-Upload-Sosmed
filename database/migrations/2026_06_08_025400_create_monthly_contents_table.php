<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monthly_contents', function (Blueprint $table) {
            $table->id();
            $table->date('month_year');
            $table->date('deadline_date');
            $table->enum('platform', ['facebook', 'instagram', 'whatsapp'])->default('facebook');
            $table->string('original_link', 500);
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['month_year', 'platform']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_contents');
    }
};