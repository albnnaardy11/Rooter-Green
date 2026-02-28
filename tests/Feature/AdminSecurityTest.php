<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AdminSecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * UNICORP-GRADE: Zero-Trust Guest Perimeter Test
     */
    public function test_guest_is_redirected_to_login()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * UNICORP-GRADE: SQL Injection Shield Verification
     */
    public function test_sqli_payload_is_blocked_by_waf()
    {
        $response = $this->get('/admin/dashboard?q=UNION SELECT password FROM users--');
        // ShieldMiddleware handles this via abort(406) or 403
        $this->assertTrue(in_array($response->status(), [403, 406]));
    }

    /**
     * UNICORP-GRADE: XSS Shield (Non-SuperAdmin)
     */
    public function test_xss_payload_blocked_for_ordinary_user()
    {
        $user = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
        
        $response = $this->actingAs($user)
            ->get('/admin/dashboard?q=<script>alert(1)</script>');
            
        $this->assertTrue(in_array($response->status(), [403, 406]));
    }

    /**
     * UNICORP-GRADE: Strategic Bypass for SuperAdmin (Safe Content)
     */
    public function test_superadmin_can_bypass_secondary_waf_but_not_critical()
    {
        $super = User::factory()->create(['role' => 'super_admin', 'email_verified_at' => now()]);
        
        // Secondary (XSS-like) should be allowed for management
        $response = $this->actingAs($super)
            ->get('/admin/dashboard?q=<script>safe_tag</script>');
        $response->assertStatus(200);

        // Critical (SQLi) should ALWAYS be blocked
        $response = $this->actingAs($super)
            ->get('/admin/dashboard?q=UNION SELECT null--');
        $this->assertTrue(in_array($response->status(), [403, 406]));
    }
}
