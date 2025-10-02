<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Journal;
use App\Observers\JournalObserver;
use App\Services\JournalService;

class JournalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(JournalService::class);
    }

    public function boot(): void
    {
        Journal::observe(JournalObserver::class);
    }
}
