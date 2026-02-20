<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WikiEntity extends Model
{
    protected $fillable = ['title', 'slug', 'category', 'description', 'wikidata_id', 'attributes'];

    protected $casts = [
        'attributes' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($entity) {
            $entity->slug = Str::slug($entity->title);
        });
    }
}
