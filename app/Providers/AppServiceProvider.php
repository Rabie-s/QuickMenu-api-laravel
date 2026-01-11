<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\User;
use App\Models\UserSubscription;
use App\Observers\MenuObserver;
use App\Observers\UserObserver;
use App\Observers\UserSubscriptionObserver;
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
        User::observe(UserObserver::class);
        Menu::observe(MenuObserver::class);
        UserSubscription::observe(UserSubscriptionObserver::class);
    }
}
