<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $casts = [
        'items' => 'json',
        'pricing' => 'json',
    ];

    public function getIconAttribute($value)
    {
        return $value ?: 'ri-drop-line';
    }
}
