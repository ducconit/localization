<?php

namespace DNT\Localization\Mixins;

use DNT\Localization\Controllers\ChangeLocalizationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouteLocalization
{
    public function localization()
    {
        return function ($callback, $attributes = []) {
            $localization = $this->container['localization'];

            $nameAction = $localization->getNameAction();

            $localeSupport = $localization->localeSupport();

            $routeGender = $this->container['config']['localization.route_gender'];

            $requestPath = Str::before($this->container['request']->path(), '/');

            $this->group($attributes, $callback);

            if ($routeGender) {
                $middlewares = $localization->getMiddleware();
                foreach ($localeSupport as $locale) {
                    $attributes = [
                        'as' => $locale . '.',
                        $nameAction => $locale,
                        'prefix' => $locale,
                        'middleware' => $middlewares
                    ];

                    if ($requestPath == $locale) {
                        $this->container->setLocale($locale);
                    }

                    $this->group($attributes, $callback);
                }
            }

        };
    }

    public function locale()
    {
        return function ($option = []) {
            $options = array_merge([
                'example' => false
            ], $option);

            $this->group(['as' => 'localization::'], function () use ($options) {
                if ($options['example']) {
                    $this->get('change-locale-example', [ChangeLocalizationController::class, 'exampleView'])->name('exampleView');
                }
                $this->get('change-locale/{locale?}', [ChangeLocalizationController::class, 'changeLocale'])->name('changeLocale');
            });
        };
    }
}