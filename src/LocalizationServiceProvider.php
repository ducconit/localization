<?php

namespace DNT\Localization;

use DNT\Localization\Contracts\LocalizationContract;
use DNT\Localization\Manager\RouteLocalizationManager;
use DNT\Localization\Mixins\RouteLocalization;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (!defined('LOCALIZATION_VENDOR_PATH')) {
            define('LOCALIZATION_VENDOR_PATH', __DIR__);
        }
        $this->mergeConfigFrom(LOCALIZATION_VENDOR_PATH . '/config/localization.php', 'localization');

        $this->app->singleton('localization', function ($app) {
            return new RouteLocalizationManager($app);
        });

        $this->loadViewsFrom(LOCALIZATION_VENDOR_PATH . '/views', 'location');

        $this->app->bind(LocalizationContract::class, 'localization');
    }

    public function boot()
    {
        $this->resolveMiddleware();
        Route::mixin(new RouteLocalization());
    }

    private function resolveMiddleware()
    {
        $this->app['localization']->pushMiddlewares();
    }
}