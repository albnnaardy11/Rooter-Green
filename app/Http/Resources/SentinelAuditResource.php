<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SentinelAuditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'audit_id' => $this->id,
            'event_type' => $this->event_type,
            'severity' => $this->severity,
            'environment' => [
                'platform' => $this->environment,
                'pathing' => $this->metrics['env_context']['pathing'] ?? 'UNKNOWN',
                'php_version' => $this->metrics['env_context']['php_version'] ?? 'UNKNOWN',
            ],
            'omni_metrics' => [
                'neural_assets' => $this->metrics['neural_assets'] ?? 'N/A',
                'memory_baseline' => $this->metrics['memory_baseline'] ?? 'N/A',
                'db_latency' => $this->metrics['db_latency'] ?? 'N/A',
                'system_efficiency' => $this->metrics['system_efficiency'] ?? 'N/A',
            ],
            'node_status' => $this->metrics['node_status'] ?? [],
            'reference_node' => $this->node_id,
            'verified_at' => $this->created_at->toIso8601String(),
        ];
    }
}
