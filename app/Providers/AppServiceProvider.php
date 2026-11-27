<?php

namespace App\Providers;

use App\Support\MockUsers;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MockUsers::class, fn () => new MockUsers());
    }

    public function boot(): void
    {
        // Bind <x-icon> to our inline-SVG anonymous component.
        Blade::component('components.icon', 'icon');

        // Make the current (mock) user available to every view.
        View::composer('*', function ($view) {
            $view->with('currentUser', session('user'));
        });
    }
}
