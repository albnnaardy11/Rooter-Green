<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SentinelAudit extends Model
{
    use HasFactory;

    protected $table = 'sentinel_audit_logs';

    protected $fillable = [
        'event_type',
        'severity',
        'metrics',
        'environment',
        'node_id'
    ];

    protected $casts = [
        'metrics' => 'array',
        'id' => 'string'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });

        // UNICORP-GRADE: Append-Only Immutable Seal
        static::updating(function ($model) {
            if (!defined('GENESIS_RESTORATION_ACTIVE')) {
                throw new \Exception("[SENTINEL] IMMUTABILITY BREACH: Audit logs are sealed and cannot be modified.");
            }
        });

        static::deleting(function ($model) {
            if (!defined('GENESIS_RESTORATION_ACTIVE')) {
                throw new \Exception("[SENTINEL] IMMUTABILITY BREACH: Audit logs are sealed and cannot be purged.");
            }
        });
    }
}
