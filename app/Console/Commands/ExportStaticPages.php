<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class ExportStaticPages extends Command
{
    protected $signature = 'export:static';
    protected $description = 'Export Blade views to static HTML files for GitHub Pages';

    public function handle()
    {
        // Force production environment to ensure Vite uses built assets
        putenv('APP_ENV=production');
        config(['app.env' => 'production']);

        // Temporarily remove hot file if it exists
        $hotFile = public_path('hot');
        $hotFileBackup = public_path('hot.bak');
        if (file_exists($hotFile)) {
            rename($hotFile, $hotFileBackup);
        }
        
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
        $this->info("Base URL: $baseUrl");

        foreach ($pages as $uri => $filename) {
            $this->info("Exporting $uri to $filename...");
            
            // Generate full URL
            $url = $baseUrl . $uri;
            
            // Use file_get_contents to hit the running server or use internal rendering
            // Internal rendering is better to avoid network issues
            try {
                // Mock request
                $request = \Illuminate\Http\Request::create($uri, 'GET');
                app()->instance('request', $request);
                
                // Get the response
                $response = app()->make(\Illuminate\Contracts\Http\Kernel::class)->handle($request);
                $html = $response->getContent();
                
                // Post-processing
                // 1. Remove CSRF token
                $html = preg_replace('/<meta name="csrf-token" content=".*">/', '', $html);

                // 2. Replace all base URLs with empty string FIRST
                $html = str_replace($baseUrl, '', $html);
                
                // 3. Fix Vite assets and other root assets - remove leading slash
                $html = str_replace(['"/build/', "'/build/", '"/images/', "'/images/", '"/models/', "'/models/", '"/sw.js"', "'/sw.js'"], ['"build/', "'build/", '"images/', "'images/", '"models/', "'models/", '"sw.js"', "'sw.js'"], $html);

                // 4. Now replace the root-relative paths with .html ones
                // Use a more generic approach for links
                $search = ['"/tentang"', "'/tentang'", '"/layanan"', "'/layanan'", '"/galeri"', "'/galeri'", '"/tips"', "'/tips'", '"/ai-diagnostic"', "'/ai-diagnostic'", '"/wiki"', "'/wiki'", '"/kontak"', "'/kontak'", '"/"', "'/'"];
                $replace = ['"about.html"', "'about.html'", '"layanan.html"', "'layanan.html'", '"galeri.html"', "'galeri.html'", '"tips.html"', "'tips.html'", '"ai-diagnostic.html"', "'ai-diagnostic.html'", '"wiki.html"', "'wiki.html'", '"kontak.html"', "'kontak.html'", '"index.html"', "'index.html'"];
                $html = str_replace($search, $replace, $html);
                
                // 5. Final cleanups
                $html = preg_replace('/href=".*\/index\.html\?lang=.*"/', 'href="index.html"', $html);
                $html = str_replace(['href="/"', 'href=""'], 'href="index.html"', $html);
                $html = str_replace(['"/favicon.ico"', "'/favicon.ico'"], ['"favicon.ico"', "'favicon.ico'"], $html);

                // Save to docs
                if (!is_dir(base_path('docs'))) {
                    mkdir(base_path('docs'), 0755, true);
                }
                file_put_contents(base_path('docs/' . $filename), $html);
                
                $this->info("Successfully exported $filename");
            } catch (\Exception $e) {
                $this->error("Failed to export $uri: " . $e->getMessage());
            }
        }

        // Restore hot file
        if (file_exists($hotFileBackup)) {
            rename($hotFileBackup, $hotFile);
        }

        return 0;
    }
}
