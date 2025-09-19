<?php

namespace App\Providers;

use App\Services\TranslationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
  public function register()
{
    $this->app->bind(TranslationService::class, function ($app) {
        return new TranslationService();
    });
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
