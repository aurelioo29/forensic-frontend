<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artifact extends Model
{
    protected $fillable = ['analysis_id', 'type', 'storage_disk', 'storage_path'];
    public function analysis()
    {
        return $this->belongsTo(Analysis::class);
    }
}
