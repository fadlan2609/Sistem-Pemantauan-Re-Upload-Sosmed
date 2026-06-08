<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum cabang untuk menambahkan 'Pusat'
        DB::statement("ALTER TABLE users MODIFY cabang ENUM('Pusat', 'Pematangsiantar', 'Sidamanik', 'Perdagangan', 'Kisaran', 'Stabat') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY cabang ENUM('Pematangsiantar', 'Sidamanik', 'Perdagangan', 'Kisaran', 'Stabat') NOT NULL");
    }
};