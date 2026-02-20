<?php

namespace App\Services\Seo;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Support\Facades\Log;

class SitemapService
{
    /**
     * Generate sitemap.xml
     * 
     * @return void
     */
    public function generate(): void
    {
        try {
            $sitemap = Sitemap::create()
                ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
                ->add(Url::create('/layanan')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
                ->add(Url::create('/galeri')->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
                ->add(Url::create('/tips')->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

            // Add Services
            Service::where('is_active', true)->get()->each(function (Service $service) use ($sitemap) {
                $sitemap->add(Url::create("/layanan/{$service->slug}")->setPriority(0.8));
            });

            // Add Blog Posts
            Post::where('status', 'published')->get()->each(function (Post $post) use ($sitemap) {
                $sitemap->add(Url::create("/tips/{$post->slug}")->setPriority(0.8));
            });

            // Add WikiPipa Entities
            \App\Models\WikiEntity::get()->each(function (\App\Models\WikiEntity $wiki) use ($sitemap) {
                $sitemap->add(Url::create("/wiki/{$wiki->slug}")->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
            });

            $sitemap->writeToFile(public_path('sitemap.xml'));
            
            Log::info('Sitemap generated successfully.');
        } catch (\Exception $e) {
            Log::error('Sitemap Generation Error: ' . $e->getMessage());
        }
    }
}
