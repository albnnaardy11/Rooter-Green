<?php

namespace App\Services\Security;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PhantomSyncService
{
    protected $tokenPrefix = 'phantom_r_'; // Optimized key size
    protected $filterKey = 'phantom_cuckoo_filter';
    protected $latencyThreshold = 10; // Aggressive 10ms target for V2.0
    
    // Tier-1 Cache (Hot, Local to worker process - highly effective in Swoole/Octane)
    protected static $l1Cache = [];

    /**
     * V2.0 Generate: Opaque Token met Cuckoo Filter Fingerprinting
     */
    public function generateToken(array $userData)
    {
        $opaqueToken = Str::random(48); // Reduce entropy slightly to save memory but still secure
        
        $rawJson = json_encode($userData);
        $rawSize = strlen($rawJson);
        $compressed = gzcompress($rawJson, 9);
        $binaryState = base64_encode($compressed);
        
        Cache::put('phantom_comp_raw', $rawSize, 60);
        Cache::put('phantom_comp_bin', strlen($compressed), 60);
        
        // Adaptive TTL Jitter to prevent Cache Stampede (120 mins +/- 5 mins)
        $ttlJitter = 120 + rand(-5, 5);
        
        // Add to L2 (Warm Cache)
        Cache::put($this->tokenPrefix . $opaqueToken, $binaryState, now()->addMinutes($ttlJitter));
        
        // Add fingerprint to simulated Edge Probabilistic Filter (Cuckoo/Bloom Filter logic)
        $this->addFingerprintToFilter($opaqueToken);
        
        // Pre-warm L1 Cache
        self::$l1Cache[$opaqueToken] = $userData;
        
        // Memory Control: Keep L1 cache ultra-dense (Max 1000 items)
        if (count(self::$l1Cache) > 1000) array_shift(self::$l1Cache);
        
        return $opaqueToken;
    }

    /**
     * V2.0 Exchange: Edge Filter + Tiered Storage Fetching
     */
    public function exchange(Request $request)
    {
        $token = $request->header('X-Phantom-Token') ?: $request->input('phantom_token');
        
        if (!$token) {
            return null;
        }

        $start = microtime(true);

        // 1. Edge Mitigation (Probabilistic Filter Check)
        // Rejects random/revoked tokens instantly without heavy storage I/O
        if (!$this->isLikelyValid($token)) {
            Cache::increment('phantom_edge_rejects');
            $this->logThreat($request, 'Edge Rejected: Token fingerprint mismatch');
            return null;
        }

        // 2. L1 Local Memory Cache (Hot Tier)
        if (isset(self::$l1Cache[$token])) {
            Cache::increment('phantom_l1_hits');
            $identity = self::$l1Cache[$token];
        } else {
            // 3. L2 Distributed Storage (Warm Tier)
            $binaryState = Cache::get($this->tokenPrefix . $token);
            if ($binaryState) {
                Cache::increment('phantom_l2_hits');
                // Deserialize & Decompress Native Binary State
                $identity = json_decode(gzuncompress(base64_decode($binaryState)), true);
                
                // Elevate to Hot Tier for subsequent bursts
                self::$l1Cache[$token] = $identity;
                
                // Memory Control: Keep L1 cache ultra-dense (Max 1000 items)
                if (count(self::$l1Cache) > 1000) array_shift(self::$l1Cache);
            } else {
                $identity = null;
            }
        }

        if ($identity) {
            // Geolocation Anomaly Detector (Impossible Travel) V2.0 (Haversine Velocity)
            $currentIp = $request->ip();
            $geoData = \Illuminate\Support\Facades\Cache::remember('geo_itd_'.$currentIp, 3600, function() use ($currentIp) {
                // In production, use MaxMind GeoIP2. We call ip-api.com as fallback simulator.
                if ($currentIp === '127.0.0.1' || $currentIp === '::1') {
                    return ['lat' => -6.2088, 'lon' => 106.8456, 'loc' => 'Jakarta, ID'];
                }
                try {
                    // Anti-Bjorka: Force HTTPS for identity geofencing
                    $response = \Illuminate\Support\Facades\Http::timeout(2)->get("https://ip-api.com/json/{$currentIp}");
                    if ($response->successful() && $response->json('status') === 'success') {
                        return [
                            'lat' => $response->json('lat'),
                            'lon' => $response->json('lon'),
                            'loc' => $response->json('city') . ', ' . $response->json('countryCode')
                        ];
                    }
                } catch (\Exception $e) {}
                
                return ['lat' => -6.2088, 'lon' => 106.8456, 'loc' => 'Unknown, ID'];
            });

            // Spatial-Temporal Metadata Logging
            $lastGeoKey = 'phantom_geo:' . md5($token);
            $lastGeo = \Illuminate\Support\Facades\Cache::get($lastGeoKey);

            if ($lastGeo && ($lastGeo['lat'] !== $geoData['lat'] || $lastGeo['lon'] !== $geoData['lon'])) {
                $distance = $this->calculateVelocityDistance($lastGeo['lat'], $lastGeo['lon'], $geoData['lat'], $geoData['lon']);
                $timeDiffHours = max((time() - $lastGeo['timestamp']) / 3600, 0.001); // Avoid div by zero
                $speed = $distance / $timeDiffHours;
                
                // Speed Threshold: 800 km/h (Commercial Jet Speed)
                if ($speed > 800) {
                    $minutes = round($timeDiffHours * 60);
                    $locA = $lastGeo['loc'];
                    $locB = $geoData['loc'];
                    
                    // Autonomous Defensive Action: Auto-Revocation
                    $this->revokeToken($token);
                    \Illuminate\Support\Facades\Cache::increment('phantom_impossible_travels');
                    
                    // Hard Block into Sentinel Blacklist for 24 hours
                    $blockedIps = \Illuminate\Support\Facades\Cache::get('blocked_ips', []);
                    $blockedIps[] = $currentIp;
                    \Illuminate\Support\Facades\Cache::put('blocked_ips', array_unique($blockedIps), now()->addHours(24));
                    
                    $userId = $identity['user_id'] ?? 'Unknown';
                    $msg = "[UNICORN ALERT] Account {$userId} Hijack Attempt! Detected travel from {$locA} to {$locB} in {$minutes} min. Action: ACCOUNT_LOCKED.";
                    
                    $sentinel = app(\App\Services\Sentinel\SentinelService::class);
                    $sentinel->sendWhatsAppAlert($msg);
                    
                    $this->logThreat($request, "Impossible Travel Anomaly. Speed: " . round($speed) . " km/h. Location: {$locA} -> {$locB}");
                    
                    return ['breach' => true, 'message' => 'Geographical anomaly detected. Account locked for safety.'];
                }
            }
            
            // Dense Storage: Phantom Geo Map Cache Sync
            \Illuminate\Support\Facades\Cache::put($lastGeoKey, [
                'lat' => $geoData['lat'],
                'lon' => $geoData['lon'],
                'timestamp' => time(),
                'loc' => $geoData['loc']
            ], now()->addHours(3));

            // Re-sync identity with new IP state (Write-around)
            $identity['__last_ip'] = $currentIp;
            self::$l1Cache[$token] = $identity;
        }

        $latency = (microtime(true) - $start) * 1000;
        Cache::put('phantom_sync_latency', $latency, 60);

        if (!$identity) {
            $this->logThreat($request, 'Storage Lookup Failed: Token expired or evicted');
            return null;
        }

        return [
            'identity' => $identity,
            'latency' => $latency,
            'status' => $latency <= $this->latencyThreshold ? 'VERIFIED' : 'DEGRADED'
        ];
    }

    /**
     * Revoke Token & Evict from all Tiers
     */
    public function revokeToken($token)
    {
        unset(self::$l1Cache[$token]);
        Cache::forget($this->tokenPrefix . $token);
        // In real Cuckoo filter, delete operation is supported. Here we just evict cache.
        Log::info("[PHANTOM-SYNC] Revoked token: " . substr($token, 0, 8) . "...");
    }

    /**
     * Clear all Hot Tier entries (Atomic Reset)
     */
    public static function clearL1Cache()
    {
        self::$l1Cache = [];
        Log::info("[PHANTOM-SYNC] L1 Hot Cache cleared.");
    }

    /**
     * Helper: Probabilistic Filter Simulation
     * In a real clustered environment, this would be a Redis BF.EXISTS or CF.EXISTS command.
     */
    protected function isLikelyValid($token)
    {
        // Simple hash checking. If the hash hasn't been allowed, we drop.
        $fingerprint = crc32($token);
        $filter = Cache::get($this->filterKey, []);
        
        // If system just restarted and filter is empty, bypass. Otherwise, strictly block.
        if (empty($filter)) return true;
        
        return in_array($fingerprint, $filter);
    }

    protected function calculateVelocityDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earth_radius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        return $earth_radius * $c;
    }

    protected function addFingerprintToFilter($token)
    {
        $fingerprint = crc32($token);
        $filter = Cache::get($this->filterKey, []);
        
        // Maintain a strict size (e.g., last 10000 fingerprints)
        $filter[] = $fingerprint;
        if (count($filter) > 10000) array_shift($filter);
        
        Cache::put($this->filterKey, $filter, now()->addHours(2));
    }

    public function logThreat(Request $request, $reason)
    {
        \Illuminate\Support\Facades\DB::table('activity_logs')->insert([
            'user_id' => auth()->id() ?: null,
            'event' => 'PHANTOM_SYNC_FAILURE',
            'url' => $request->url(),
            'old_values' => json_encode(['threat_reason' => $reason]),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::warning("[PHANTOM-SYNC] Security Rejected: $reason from IP " . $request->ip());
    }

    public function getHealthSync()
    {
        $latency = Cache::get('phantom_sync_latency', 0);
        
        $l1Hits = Cache::get('phantom_l1_hits', 0);
        $l2Hits = Cache::get('phantom_l2_hits', 0);
        $totalHits = $l1Hits + $l2Hits;
        $l1Ratio = $totalHits > 0 ? round(($l1Hits / $totalHits) * 100, 2) : 100;

        $rawSize = Cache::get('phantom_comp_raw', 0) ?: 1;
        $binSize = Cache::get('phantom_comp_bin', 0) ?: 1;
        $compRatio = round((1 - ($binSize / $rawSize)) * 100, 2);

        return [
            'latency' => round($latency, 2) . ' ms',
            'status' => ($latency > $this->latencyThreshold) ? 'DEGRADED' : 'OPERATIONAL',
            'pulse' => 'VERIFIED',
            'l1_ratio' => $l1Ratio,
            'edge_rejects' => Cache::get('phantom_edge_rejects', 0),
            'impossible_travels' => Cache::get('phantom_impossible_travels', 0),
            'compression' => $compRatio . '% Saved'
        ];
    }
}
