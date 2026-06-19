<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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
        view()->composer('layouts.admin', function ($view) {

            $notifs = DatabaseNotification::where('notifiable_type', User::class)->latest()->get();

            $view->with('notifs', $notifs);
        });
    }
}
