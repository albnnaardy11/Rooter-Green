<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoCrawlLog extends Model
{
    protected $fillable = [
        'url', 
        'user_agent', 
        'status_code', 
        'is_in_sitemap', 
        'action_taken', 
        'ip_address', 
        'is_googlebot', 
        'metadata',
        'crawled_at'
    ];

    protected $casts = [
        'metadata' => 'json',
        'is_in_sitemap' => 'boolean',
        'is_googlebot' => 'boolean',
        'crawled_at' => 'datetime'
    ];
}
