<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyContent extends Model
{
    protected $table = 'monthly_contents';

    protected $fillable = [
        'month_year',
        'deadline_date',
        'platform',
        'original_link',
        'description',
        'created_by',
    ];

    protected $casts = [
        'month_year' => 'date',
        'deadline_date' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reuploadLogs()
    {
        return $this->hasMany(ReuploadLog::class, 'content_id'); // PERBAIKI: pakai content_id
    }

    // PERBAIKI method ini
    public function isUploadedByUser($userId)
    {
        return $this->reuploadLogs()
            ->where('user_id', $userId)
            ->where('status', 'verified')
            ->exists();
    }
}