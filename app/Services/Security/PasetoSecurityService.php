<?php

namespace App\Services\Security;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class PasetoSecurityService
{
    private $key;
    private const VERSION = 'v4.local.';

    public function __construct()
    {
        // Use a 32-byte key derived from APP_KEY for PASETO v4.local
        $this->key = hash('sha256', config('app.key'), true);
    }

    /**
     * PASETO v4.local Implementation
     * Format: v4.local.<base64url(nonce + ciphertext + tag)>
     */
    public function encrypt(array $payload, string $footer = ''): string
    {
        $nonce = random_bytes(24); // XChaCha20 nonce
        $payloadJson = json_encode($payload);
        
        $ciphertext = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt(
            $payloadJson,
            $footer,
            $nonce,
            $this->key
        );

        $binaryHeader = self::VERSION;
        $tokenData = $nonce . $ciphertext;
        
        $encoded = self::VERSION . $this->base64UrlEncode($tokenData);
        
        if (!empty($footer)) {
            $encoded .= '.' . $this->base64UrlEncode($footer);
        }

        return $encoded;
    }

    /**
     * PASETO v4.local Decryption
     */
    public function decrypt(string $token): ?array
    {
        if (!str_starts_with($token, self::VERSION)) {
            return null;
        }

        $parts = explode('.', $token);
        if (count($parts) < 3) return null;

        $header = $parts[0] . '.' . $parts[1] . '.';
        $tokenData = $this->base64UrlDecode($parts[2]);
        $footer = isset($parts[3]) ? $this->base64UrlDecode($parts[3]) : '';

        if (strlen($tokenData) < 24) return null;

        $nonce = substr($tokenData, 0, 24);
        $ciphertext = substr($tokenData, 24);

        $decrypted = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt(
            $ciphertext,
            $footer,
            $nonce,
            $this->key
        );

        return $decrypted ? json_decode($decrypted, true) : null;
    }

    /**
     * Phantom Token Pattern: Opaque (Client) -> PASETO (Backend)
     */
    public function createPhantomPair(array $data, int $ttl = 3600): string
    {
        // 1. Generate PASETO (The real secure token)
        $paseto = $this->encrypt($data);
        
        // 2. Generate Opaque Token (The phantom/masked token)
        $opaque = bin2hex(random_bytes(16)) . '-' . uniqid();
        
        // 3. Map Opaque -> PASETO in secure cache
        Cache::put("phantom_token:{$opaque}", $paseto, $ttl);
        
        Log::info("[SECURITY] Phantom Token Pair Created. Opaque masked.");
        
        return $opaque;
    }

    /**
     * Exchange Opaque for PASETO
     */
    public function getBackendToken(string $opaque): ?string
    {
        return Cache::get("phantom_token:{$opaque}");
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
