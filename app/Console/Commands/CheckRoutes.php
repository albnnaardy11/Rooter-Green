<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class CheckRoutes extends Command
{
    protected $signature = 'check:routes';
    protected $description = 'Command description';

    public function handle()
    {
        foreach (Route::getRoutes() as $route) {
            if (strpos($route->uri(), 'admin/users') !== false) {
                $this->info($route->uri() . ' - ' . implode(', ', $route->gatherMiddleware()));
            }
        }
    }
}
