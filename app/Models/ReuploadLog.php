<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReuploadLog extends Model
{
    protected $table = 'reupload_logs';

    protected $fillable = [
        'user_id',
        'content_id',      // PERBAIKI: pakai content_id, bukan monthly_content_id
        'uploaded_link',
        'uploaded_at',
        'verified_by',
        'status',
        'notes',
    ];

    protected $casts = [
        'uploaded_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function content()
    {
        return $this->belongsTo(MonthlyContent::class, 'content_id'); // PERBAIKI
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}