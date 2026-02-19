<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use LogsActivity;
    protected $guarded = [];

    protected $casts = [
        'images' => 'json',
        'is_featured' => 'boolean',
    ];
}
