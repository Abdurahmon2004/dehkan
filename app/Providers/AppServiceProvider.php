<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
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
        $locale = Request::header('Accept-Language');
        $accepted = ['uz', 'ru', 'en'];
        if ($locale && in_array($locale, $accepted)) {
            App::setLocale($locale);
        }
    }
}
