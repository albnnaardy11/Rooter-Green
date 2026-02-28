<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoAuditLog extends Model
{
    protected $guarded = [];
    protected $casts = [
        'previous_state' => 'array',
        'new_state' => 'array',
    ];
}
