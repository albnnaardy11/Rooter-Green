<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Services\Sentinel\SentinelService;
use App\Services\Security\SecurityAutomationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseCorruptionAssaultTest extends TestCase
{
    use RefreshDatabase;

    /**
     * BRUTAL ASSAULT: DIRECT DATABASE CORRUPTION
     */
    public function test_sentinel_survives_and_reports_database_corruption()
    {
        Cache::flush();
        
        $automation = app(SecurityAutomationService::class);
        $recoveryLog = storage_path('logs/emergency_audit.log');
        if (File::exists($recoveryLog)) File::delete($recoveryLog);

        // 1. Simulasikan kegagalan DB hanya untuk tabel tertentu
        // Kita gunakan Mockery secara langsung agar lebih kontrol
        DB::shouldReceive('table')->with('activity_logs')->andThrow(new \PDOException("Table activity_logs is corrupted"));
        
        // Mocking for other calls to prevent crash
        DB::shouldReceive('table')->with('seo_settings')->andReturn(new class {
            public function where() { return $this; }
            public function first() { return null; }
            public function updateOrCreate() { return true; }
        });
        DB::shouldReceive('connection')->andReturn(null);

        // 2. Brutal Action: Audit Log saat DB Corrupt
        $automation->auditLog('CRITICAL_FAILURE_TEST', ['status' => 'Testing Failover']);

        // 3. Verification: Harus ada di file emergency
        $this->assertTrue(File::exists($recoveryLog));
        $this->assertStringContainsString('CRITICAL_FAILURE_TEST', File::get($recoveryLog));

        \Mockery::close();
    }

    /**
     * ASSAULT: DATABASE SATURATION & TIMEOUT (High Latency)
     */
    public function test_sentinel_detects_db_latency_poisoning()
    {
        Cache::flush();
        Cache::put('last_db_latency', 5001); 

        $sentinel = app(SentinelService::class);
        $automation = app(SecurityAutomationService::class);

        // Act
        $automation->pulseLockdown();

        // Assert
        $this->assertTrue($automation->isLockedDown());
        
        $report = $sentinel->monitorAll();
        $this->assertTrue($report['security']['lockdown']['active']);
    }
}
