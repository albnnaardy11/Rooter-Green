<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    protected $guarded = [];

    public function seoable()
    {
        return $this->morphTo();
    }
}
