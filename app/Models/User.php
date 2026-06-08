<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'cabang',
        'posisi',
        'fb_url',
        'ig_url',
        'wa_number',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function createdContents()
    {
        return $this->hasMany(MonthlyContent::class, 'created_by');
    }

    // PERBAIKI: tambahkan foreign key
    public function reuploadLogs()
    {
        return $this->hasMany(ReuploadLog::class, 'user_id');
    }

    public function verifiedLogs()
    {
        return $this->hasMany(ReuploadLog::class, 'verified_by');
    }
}