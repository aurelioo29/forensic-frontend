<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'user_id',
        'original_filename',
        'mime_type',
        'size_bytes',
        'storage_disk',
        'storage_path',
        'sha256',
        'is_private'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function analyses()
    {
        return $this->hasMany(Analysis::class);
    }
    public function latestAnalysis()
    {
        return $this->hasOne(Analysis::class)->latestOfMany();
    }
    public function historyEvents()
    {
        return $this->hasMany(HistoryEvent::class);
    }
}
