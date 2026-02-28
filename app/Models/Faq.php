<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'faq_category_id',
        'question',
        'answer',
        'placement',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }

    public function scopeAbout($query)
    {
        return $query->whereIn('placement', ['about', 'both'])->where('is_active', true);
    }

    public function scopeLanding($query)
    {
        return $query->whereIn('placement', ['landing', 'both'])->where('is_active', true);
    }
}
