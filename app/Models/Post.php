<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use LogsActivity;
    protected $guarded = [];

    public function seo()
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
