<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogVerification extends Model
{
    protected $fillable = [
        'log_id',
        'verified_by',
        'status',
        'notes',
    ];

    public function log()
    {
        return $this->belongsTo(Log::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
