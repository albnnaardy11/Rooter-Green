<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\AiDiagnose::observe(\App\Observers\AiDiagnoseObserver::class);
        \App\Models\WikiEntity::observe(\App\Observers\WikiEntityObserver::class);

        // Auto-login for development and CMS testing
        if (!app()->runningInConsole() && !\Illuminate\Support\Facades\Auth::check()) {
            $admin = \App\Models\User::first();
            if ($admin) {
                \Illuminate\Support\Facades\Auth::login($admin);
            }
        }
    }
}
