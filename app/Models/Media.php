<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $guarded = [];

    public function getUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->path);
    }
}
