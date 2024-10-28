<?php

namespace AllanDereal\PesaPal;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use AllanDereal\PesaPal\Facades\Payments;
use AllanDereal\PesaPal\Models\Cart;
use AllanDereal\PesaPal\Actions\ConstructWebhookEvent;
use AllanDereal\PesaPal\Concerns\ConstructsWebhookEvent;
use AllanDereal\PesaPal\Managers\PesaPalManager;

class PesaPalServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app->bind(ConstructsWebhookEvent::class, function ($app) {
            return $app->make(ConstructWebhookEvent::class);
        });

        $this->app->singleton('allandereal:pesapal', function ($app) {
            return $app->make(PesaPalManager::class);
        });

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'lunar');
        $this->loadRoutesFrom(__DIR__.'/../routes/webhooks.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->mergeConfigFrom(__DIR__.'/../config/pesapal.php', 'allandereal.pesapal');

        $this->publishes([
            __DIR__.'/../config/pesapal.php' => config_path('pesapal.php'),
        ], 'allandereal.pesapal.config');
    }
}
