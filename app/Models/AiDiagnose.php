<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiDiagnose extends Model
{
    protected $fillable = [
        'diagnose_id',
        'result_label',
        'audio_label',
        'audio_confidence',
        'survey_data',
        'final_deep_score',
        'analysis_version',
        'recommended_tools',
        'confidence_score',
        'latitude',
        'longitude',
        'material_type',
        'location_context',
        'city_location',
        'image_path',
        'image_hash',
        'status',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'survey_data' => 'array',
        'latitude' => 'float',
        'longitude' => 'float',
        'confidence_score' => 'integer',
        'audio_confidence' => 'integer'
    ];
}
