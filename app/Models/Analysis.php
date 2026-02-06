<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    protected $fillable = ['photo_id', 'status', 'score', 'result_json', 'error_message'];
    protected $casts = ['result_json' => 'array'];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
    public function artifacts()
    {
        return $this->hasMany(Artifact::class);
    }
}
