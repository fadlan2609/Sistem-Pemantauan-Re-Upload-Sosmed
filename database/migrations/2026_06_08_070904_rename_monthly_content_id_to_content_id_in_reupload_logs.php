<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reupload_logs', function (Blueprint $table) {
            // Rename kolom jika ada
            if (Schema::hasColumn('reupload_logs', 'monthly_content_id')) {
                $table->renameColumn('monthly_content_id', 'content_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reupload_logs', function (Blueprint $table) {
            if (Schema::hasColumn('reupload_logs', 'content_id')) {
                $table->renameColumn('content_id', 'monthly_content_id');
            }
        });
    }
};