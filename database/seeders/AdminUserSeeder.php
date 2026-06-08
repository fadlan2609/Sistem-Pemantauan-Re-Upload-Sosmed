<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@bprs.com'],
            [
                'name' => 'Admin BPRS',
                'email' => 'admin@bprs.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'cabang' => 'Pusat',  // UPDATE: dari Pematangsiantar ke Pusat
                'posisi' => 'Administrator',
            ]
        );
    }
}