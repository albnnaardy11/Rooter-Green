<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use App\Models\User;

class IronCladOffensiveTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Disable non-core middlewares for cleaner simulation
        $this->withoutMiddleware([
            \App\Http\Middleware\TrackVisitors::class,
            \App\Http\Middleware\AdminAuditLogger::class,
        ]);
    }

    /**
     * TEST 1: Lockdown Breakthrough (Admin Bunker Mode)
     */
    public function test_lockdown_breakthrough_is_blocked()
    {
        Cache::put('system_lockdown_active', true, 60);
        
        // Mock a Super Admin
        $admin = User::factory()->create(['role' => 'super_admin']);
        
        $response = $this->actingAs($admin)->post('/admin/projects', [
            'name' => 'Should fail',
            'description' => 'Test'
        ]);

        $response->assertStatus(403);
        $this->assertStringContainsString('IRON-CLAD POLICY', $response->getContent());
        
        // Cleanup
        Cache::forget('system_lockdown_active');
        $admin->delete();
    }

    /**
     * TEST 2: WAF Obfuscation (Double-Encoded SQLi)
     */
    public function test_waf_obfuscation_unmasking()
    {
        // Payload: ' OR 1=1 (double encoded)
        $payload = '%2527%2520OR%25201%253D1';
        
        $response = $this->get('/?id=' . $payload);

        $response->assertStatus(406);
        // Note: Generic error page might not show the message, so we just verify status
    }

    /**
     * TEST 3: Production Env Parity (Absolute Debug Suppressor)
     */
    public function test_production_absolute_debug_suppression()
    {
        // Force the app into production mode for this test
        $this->app->detectEnvironment(fn() => 'production');
        Config::set('app.debug', true);
        
        // Ensure middleware runs
        $this->get('/');
        
        $this->assertFalse(config('app.debug'), 'APP_DEBUG must be forced to false in production environment');
    }
}
