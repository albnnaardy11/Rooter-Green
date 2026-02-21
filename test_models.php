<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$key = env('GEMINI_API_KEY');
$response = Http::get("https://generativelanguage.googleapis.com/v1beta/models?key={$key}");
print_r(collect($response->json('models'))->pluck('name')->toArray());
