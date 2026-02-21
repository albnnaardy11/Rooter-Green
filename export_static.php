<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Project;
use App\Models\WikiEntity;
use App\Models\Post;

// Load Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Define pages to export
$pages = [
    '/' => 'index.html',
    '/tentang' => 'about.html',
    '/layanan' => 'layanan.html',
    '/galeri' => 'galeri.html',
    '/tips' => 'tips.html',
    '/ai-diagnostic' => 'ai-diagnostic.html',
    '/wiki' => 'wiki.html',
    '/kontak' => 'kontak.html',
];

$baseUrl = config('app.url', 'http://localhost');

foreach ($pages as $uri => $filename) {
    echo "Exporting $uri to $filename...\n";
    
    // Create a request for the URI
    $request = Request::create($uri, 'GET');
    $app->instance('request', $request);
    
    // Manually handle some data since we might not have a full DB state or specific controller logic
    // OR we can just try to run the route itself
    try {
        $response = $kernel->handle($request);
        $html = $response->getContent();
    } catch (\Exception $e) {
        echo "Error exporting $uri: " . $e->getMessage() . "\n";
        continue;
    }

    // Post-processing
    // 1. Replace absolute localhost URLs with relative ones
    $html = str_replace($baseUrl . '/tentang', 'about.html', $html);
    $html = str_replace($baseUrl . '/layanan', 'layanan.html', $html);
    $html = str_replace($baseUrl . '/galeri', 'galeri.html', $html);
    $html = str_replace($baseUrl . '/tips', 'tips.html', $html);
    $html = str_replace($baseUrl . '/ai-diagnostic', 'ai-diagnostic.html', $html);
    $html = str_replace($baseUrl . '/wiki', 'wiki.html', $html);
    $html = str_replace($baseUrl . '/kontak', 'kontak.html', $html);
    $html = str_replace($baseUrl . '/', 'index.html', $html);
    
    // Fix any remaining localhost links if any
    $html = str_replace($baseUrl, '.', $html);

    // Save to docs
    file_put_contents(__DIR__ . '/docs/' . $filename, $html);
}

echo "Done!\n";
