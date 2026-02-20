<?php

namespace App\Console\Commands;

use App\Services\Seo\BlogAutopilotService;
use Illuminate\Console\Command;

class BlogAutopilotCommand extends Command
{
    protected $signature = 'blog:autopilot';
    protected $description = 'AI Content Autopilot - Generates and publishes fresh SEO-optimized blog posts.';

    public function handle(BlogAutopilotService $autopilot)
    {
        $this->info('Starting AI Journalist Engine...');
        
        $post = $autopilot->execute();

        $this->info("Success! New Masterpiece Published: {$post->title}");
        $this->info("URL: " . route('tips.detail', $post->slug));
    }
}
