<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryEvent extends Model
{
    protected $fillable = ['user_id', 'photo_id', 'event_type', 'message'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}
