<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'diagnose_id',
        'material_type',
        'location_context',
        'ai_result',
        'confidence_score',
        'severity_score',
        'audio_analysis',
        'recommended_tools',
        'city_location',
        'raw_survey_data',
        'metadata',
        'status'
    ];

    protected $casts = [
        'raw_survey_data' => 'array',
        'metadata' => 'array',
    ];
}
