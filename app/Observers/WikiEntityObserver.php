<?php

namespace App\Observers;

use App\Models\WikiEntity;
use App\Services\Seo\GoogleIndexingService;
use Illuminate\Support\Facades\Log;

class WikiEntityObserver
{
    protected $indexing;

    public function __construct(GoogleIndexingService $indexing)
    {
        $this->indexing = $indexing;
    }

    /**
     * Handle the WikiEntity "created" event.
     */
    public function created(WikiEntity $entity): void
    {
        $this->fireRocket($entity);
    }

    /**
     * Handle the WikiEntity "updated" event.
     */
    public function updated(WikiEntity $entity): void
    {
        $this->fireRocket($entity);
    }

    protected function fireRocket(WikiEntity $entity)
    {
        $url = url('/wiki/' . $entity->slug);
        
        Log::info("[SEO] Instant Indexing Rocket: Preparing launch for $url");
        
        $result = $this->indexing->notifyUpdate($url);
        
        if (!$result['success']) {
            Log::warning("[SEO] Rocket Failover: Activating Caching Node for $url. Reason: " . $result['message']);
            // Standard Caching for Failover
            \Illuminate\Support\Facades\Cache::put('seo_retry:' . $entity->slug, $url, 86400);
        } else {
            Log::info("[SEO] Rocket Impact: Google confirmed indexing notification.");
        }
    }
}
