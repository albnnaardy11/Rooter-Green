<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use LogsActivity;
    protected $guarded = [];

    protected $casts = [
        'items' => 'json',
        'pricing' => 'json',
    ];

    public function getIconAttribute($value)
    {
        return $value ?: 'ri-drop-line';
    }

    public function seo()
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
