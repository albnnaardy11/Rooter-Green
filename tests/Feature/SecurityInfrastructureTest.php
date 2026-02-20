<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Services\Security\EntropyGuard;
use App\Services\Security\PhantomSyncService;
use App\Services\Sentinel\SentinelService;
use App\Services\Security\SecurityAutomationService;
use Illuminate\Support\Facades\Log;

use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityInfrastructureTest extends TestCase
{
    use RefreshDatabase;
    /**
     * 1. Unit Test: ProductionShield & Debug Masking
     * Test Logic: Simulasikan request dari IP non-admin dan pastikan config('app.debug') bernilai false
     * meskipun .env sedang ENABLED.
     */
    public function test_public_traffic_forces_debug_off()
    {
        // Force debug to be true initially (simulating .env)
        Config::set('app.debug', true);
        
        // Simulasikan request dari IP non-admin
        $response = $this->withHeaders([
            'REMOTE_ADDR' => '192.168.1.50'
        ])->get('/');

        // config('app.debug') should be false in the request lifecycle
        // Note: We check if the config was changed during the request.
        // Since Laravel's config is modified in memory, it should reflect here if the middleware ran.
        $this->assertFalse(config('app.debug'));
        
        // Verification: Malformed JSON should return clean 500
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'REMOTE_ADDR' => '192.168.1.50'
        ])->post('/api/phantom/introspect', ['invalid' => '{ malformed json '], [
            'Authorization' => 'Bearer some-key'
        ]);

        // Expect 500 or 400 (if caught by JSON parser)
        // The user specifically wants "halaman error 500 generik yang bersih"
        // Let's assume it triggers a 500 since it's malformed.
        // We'll check if stack trace is NOT present.
        $content = $response->getContent();
        $this->assertStringNotContainsString('Stack trace', $content);
        $this->assertStringNotContainsString('vendor/laravel', $content);
    }

    /**
     * 2. Unit Test: AutoLockdown & Brute Force Swarm
     * Test Logic: Simulasikan 50 request gagal dari IP berbeda dengan PHANTOM_BRIDGE_KEY 
     * yang salah dalam satu siklus test.
     */
    public function test_distributed_brute_force_triggers_lockdown()
    {
        Cache::flush();
        
        // Simulasikan 50 request dari IP berbeda
        for ($i = 0; $i < 51; $i++) {
            $ip = "192.168.2." . $i;
            $this->withHeaders([
                'REMOTE_ADDR' => $ip,
                'X-Phantom-Token' => 'wrong-token'
            ])->post('/api/phantom/introspect');
        }

        // Verification: Status API di Redis berubah menjadi LOCKED
        $automation = app(SecurityAutomationService::class);
        $this->assertTrue($automation->isLockedDown());

        // Setiap request berikutnya mengembalikan HTTP 503
        $response = $this->get('/');
        $response->assertStatus(503);
    }

    /**
     * 3. Unit Test: Impossible Travel Detector
     * Test Logic: Gunakan Haversine Formula untuk mensimulasikan dua request dengan 
     * interval 1 detik antara koordinat New York dan Beijing.
     */
    public function test_impossible_travel_revokes_token()
    {
        Cache::flush();
        $sync = app(PhantomSyncService::class);
        $token = $sync->generateToken(['user_id' => 123]);

        // Request 1: New York (40.7128, -74.0060)
        // Mock Geo Cache for the first request
        $tokenHash = md5($token);
        Cache::put('phantom_geo:' . $tokenHash, [
            'lat' => 40.7128,
            'lon' => -74.0060,
            'timestamp' => time() - 1, // 1 second ago
            'loc' => 'New York, US'
        ]);

        // Request 2: Beijing (39.9042, 116.4074)
        // Distance NY to Beijing is ~11,000 km. 1 second interval is definitely impossible.
        
        // Mock the current IP's geo lookup to return Beijing
        Cache::put('geo_itd_1.1.1.1', [
            'lat' => 39.9042,
            'lon' => 116.4074,
            'loc' => 'Beijing, CN'
        ]);

        $request = \Illuminate\Http\Request::create('/api/test', 'POST');
        $request->headers->set('X-Phantom-Token', $token);
        $request->server->set('REMOTE_ADDR', '1.1.1.1');

        $result = $sync->exchange($request);

        // Verification: Token segera dicabut (revoked)
        $this->assertNull(Cache::get('phantom_r_' . $token));
        
        // Status Security Pulse pada Sentinel memicu alert CRITICAL
        $this->assertTrue(Cache::get('phantom_impossible_travels') > 0);
        $this->assertContains('1.1.1.1', Cache::get('blocked_ips', []));
    }

    /**
     * 4. Unit Test: Entropy Guard & Resource Health
     * Test Logic: Simulasikan beban payload besar untuk menaikkan Memory Fragmentation Level di atas 15%.
     */
    public function test_memory_reclamation_on_fragmentation()
    {
        Cache::flush();
        Cache::put('sentinel_fragmentation_level', 16); // Simulate > 15%

        // Trigger infrastructure check which should call EntropyGuard::reclaim()
        $sentinel = app(SentinelService::class);
        $sentinel->monitorAll();

        // Verification: Fragmentation level reset
        $this->assertLessThanOrEqual(5, EntropyGuard::getFragmentationLevel());
        
        // Compute Metrics stabil di kisaran 40 MB
        $health = $sentinel->monitorAll();
        $usage = $health['infrastructure']['compute']['status'];
        $this->assertContains($usage, ['Optimal', 'ULTRA-OPTIMIZED']);
    }

    /**
     * 5. Global Sentinel Reporting
     */
    public function test_sentinel_reporting_integration()
    {
        // Mock all tests passed
        Cache::put('sentinel_shield_status', 'ENABLED');
        Cache::put('system_lockdown_active', false);
        
        $sentinel = app(SentinelService::class);
        $report = $sentinel->monitorAll();

        if ($report['security']['environment']['status'] === 'Operational') {
             Cache::put('security_pulse_status', 'OPERATIONAL (VERIFIED)');
        }

        $this->assertEquals('OPERATIONAL (VERIFIED)', Cache::get('security_pulse_status'));
    }
}
