<?php

namespace App\Providers;

use App\Events\AlertDepositSuccessCrypto;
use App\Events\MyEvent;
use App\Events\UpdateIndex;
use Illuminate\Support\Facades\Event;
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
        // Listen for AlertDepositSuccessCrypto and handle its logic
        Event::listen(AlertDepositSuccessCrypto::class, function ($event) {
            
        });

        // Listen for UpdateIndex and handle its logic
        Event::listen(UpdateIndex::class, function ($event) {
        });
    }
}
