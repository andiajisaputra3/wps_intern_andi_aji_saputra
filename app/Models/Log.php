<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal',
        'aktivitas',
        'bukti_pekerjaan',
        'status',
        'catatan_atasan',
        'atasan_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }

    public function logVerifications()
    {
        return $this->hasMany(LogVerification::class);
    }
}