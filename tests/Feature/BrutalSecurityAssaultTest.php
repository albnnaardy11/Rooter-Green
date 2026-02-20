<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\Security\PhantomSyncService;
use App\Services\Security\SecurityAutomationService;
use App\Services\Security\EntropyGuard;
use App\Services\Sentinel\SentinelService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrutalSecurityAssaultTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ASSAULT 1: The "Death by 10,000 Cuts" (Cuckoo Filter Pressure)
     * Simulasi serangan flooding dengan 500 token random untuk melihat apakah
     * Cuckoo Filter (Edge Mitigation) menolak semua I/O tanpa menghabiskan memory.
     */
    public function test_edge_mitigation_resists_token_flooding()
    {
        Cache::flush();
        $sync = app(PhantomSyncService::class);
        
        // Pre-fill filter with 1 legitimate token
        $validToken = $sync->generateToken(['user_id' => 1]);
        
        $startMemory = memory_get_usage();
        
        // Simulasikan 500 request dengan token sampah (Malicious Flooding)
        for ($i = 0; $i < 500; $i++) {
            $request = \Illuminate\Http\Request::create('/api/phantom/introspect', 'POST');
            $request->headers->set('X-Phantom-Token', 'malicious-token-' . $i);
            $sync->exchange($request);
        }
        
        $endMemory = memory_get_usage();
        $memoryDiff = ($endMemory - $startMemory) / 1024; // KB

        // Verification: Edge rejects harus terhitung tinggi
        // 500 malicious + initial state
        $this->assertEquals(500, Cache::get('phantom_edge_rejects'));
        
        // Memory tidak boleh naik drastis (Max leak 2MB untuk logs/metadata)
        $this->assertLessThan(2048, $memoryDiff, "Memory leak detected during flooding assault!");
        
        // Token asli harus tetap bisa diakses
        $validRequest = \Illuminate\Http\Request::create('/api/phantom/introspect', 'POST');
        $validRequest->headers->set('X-Phantom-Token', $validToken);
        $result = $validRequest ? $sync->exchange($validRequest) : null;
        $this->assertEquals('VERIFIED', $result['status'] ?? '');
    }

    /**
     * ASSAULT 2: The "Quantum" Impossible Travel (Velocity Stress)
     * Satu user berpindah antar 5 koordinat global dalam interval milidetik.
     */
    public function test_quantum_travel_cascade_lockdown()
    {
        Cache::flush();
        $sync = app(PhantomSyncService::class);
        $token = $sync->generateToken(['user_id' => 777]);
        
        $coordinates = [
            ['lat' => -6.2088, 'lon' => 106.8456, 'loc' => 'Jakarta'],    // Base
            ['lat' => 35.6762, 'lon' => 139.6503, 'loc' => 'Tokyo'],      // 1ms later
            ['lat' => 51.5074, 'lon' => -0.1278, 'loc' => 'London'],     // 2ms later
            ['lat' => 40.7128, 'lon' => -74.0060, 'loc' => 'New York'],  // 3ms later
            ['lat' => -33.8688, 'lon' => 151.2093, 'loc' => 'Sydney'],    // 4ms later
        ];

        foreach ($coordinates as $idx => $coord) {
            // Mock geo data for this specific IP call
            $ip = "10.0.0." . $idx;
            Cache::put('geo_itd_' . $ip, $coord);
            
            // Mock the PREVIOUS timestamp to be exactly now - 1 second for each jump
            if ($idx > 0) {
                $lastGeoKey = 'phantom_geo:' . md5($token);
                $oldGeo = Cache::get($lastGeoKey);
                $oldGeo['timestamp'] = time() - 1; // Force 1s diff
                Cache::put($lastGeoKey, $oldGeo);
            }

            $request = \Illuminate\Http\Request::create('/api/v1/secure', 'GET');
            $request->headers->set('X-Phantom-Token', $token);
            $request->server->set('REMOTE_ADDR', $ip);
            
            $result = $sync->exchange($request);

            if ($idx === 1) {
                // The very first jump must be detected as a breach
                $this->assertIsArray($result, "Result should be an array on first jump");
                $this->assertArrayHasKey('breach', $result, "Failed to detect initial jump to Tokyo");
                $this->assertTrue($result['breach']);
            } elseif ($idx > 1) {
                // Subsequent jumps should return null because token was revoked at idx 1
                $this->assertNull($result, "Token should be null/revoked at index {$idx}");
            }
        }

        // Final verification: Token harus benar-benar mati di semua Cache Tier
        $this->assertNull(Cache::get('phantom_r_' . $token));
        $this->assertContains('10.0.0.1', Cache::get('blocked_ips', [])); // IP Tokyo blocked
    }

    /**
     * ASSAULT 3: Multi-Vector Resource Bomb (OOM Simulation)
     * Flood audit log dengan payload raksasa + paksa fragmentasi di atas 80%
     * untuk melihat apakah Sentinel mampu melakukan self-healing darurat.
     */
    public function test_resource_bomb_triggers_emergency_reclamation()
    {
        Cache::flush();
        $automation = app(SecurityAutomationService::class);
        
        // Simulasikan 100 audit logs dengan data berat
        $heavyData = str_repeat('A', 1024 * 10); // 10KB per log
        for ($i = 0; $i < 50; $i++) {
            $automation->auditLog('STRESS_TEST', ['payload' => $heavyData]);
        }

        // Paksa fragmented state secara brutal
        Cache::put('sentinel_fragmentation_level', 85); 
        
        $sentinel = app(SentinelService::class);
        $health = $sentinel->monitorAll();

        // Verification: EntropyGuard harus dipanggil secara otomatis
        // dan menurunkan fragmentasi ke level aman (< 5%)
        $this->assertLessThanOrEqual(5, EntropyGuard::getFragmentationLevel());
        $this->assertContains($health['infrastructure']['compute']['status'], ['Optimal', 'ULTRA-OPTIMIZED']);
    }

    /**
     * ASSAULT 4: Nuclear Token Rotation (Atomic Persistence Test)
     * Eksekusi Global Token Rotation saat tengah terjadi ribuan request aktif.
     * Memastikan tidak ada "Zombies" (token lama) yang bisa tembus.
     */
    public function test_nuclear_rotation_wipes_all_zombies()
    {
        Cache::flush();
        $sync = app(PhantomSyncService::class);
        $automation = app(SecurityAutomationService::class);

        // Generate 100 "Zombie" tokens
        $zombies = [];
        for ($i = 0; $i < 100; $i++) {
            $zombies[] = $sync->generateToken(['user_id' => $i]);
        }

        // NUCLEAR OPTION: Rotate all tokens
        $automation->rotateTokens();

        // Verifikasi: Tidak boleh ada satupun zombie yang valid
        foreach ($zombies as $token) {
            $request = \Illuminate\Http\Request::create('/api/test', 'GET');
            $request->headers->set('X-Phantom-Token', $token);
            $this->assertNull($sync->exchange($request), "Zombie token {$token} survived the nuclear rotation!");
        }
    }
}
