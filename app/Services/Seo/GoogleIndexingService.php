<?php

namespace App\Services\Seo;

use Google\Client;
use Google\Service\Indexing;
use App\Models\SeoSetting;
use Illuminate\Support\Facades\Log;

class GoogleIndexingService
{
    protected $client;
    protected $isConfigured = false;

    public function __construct()
    {
        $this->client = new Client();
        $this->isConfigured = $this->setupClient();
    }

    protected function setupClient()
    {
        $jsonKey = SeoSetting::where('key', 'google_indexing_key')->first()?->value;

        if ($jsonKey) {
            try {
                $credentials = json_decode($jsonKey, true);
                if ($credentials) {
                    $this->client->setAuthConfig($credentials);
                    $this->client->addScope('https://www.googleapis.com/auth/indexing');
                    return true;
                }
            } catch (\Exception $e) {
                Log::error('Google Indexing API Auth Error: ' . $e->getMessage());
            }
        }
        return false;
    }

    /**
     * Notify Google that a URL has been updated or created.
     */
    public function notifyUpdate(string $url)
    {
        if (!$this->isConfigured) {
            return ['success' => false, 'message' => 'Google Indexing Credentials not configured.'];
        }

        try {
            $indexing = new Indexing($this->client);
            $urlNotification = new Indexing\UrlNotification();
            $urlNotification->setUrl($url);
            $urlNotification->setType('URL_UPDATED');

            $result = $indexing->urlNotifications->publish($urlNotification);
            
            return [
                'success' => true, 
                'message' => 'Google Indexing Rocket Fired!',
                'data' => $result
            ];
        } catch (\Exception $e) {
            Log::error('Google Indexing API Error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Batch send indexing requests for multiple URLs.
     */
    public function batchNotify(array $urls)
    {
        $results = [];
        foreach ($urls as $url) {
            $results[] = $this->notifyUpdate($url);
        }
        return $results;
    }
}
