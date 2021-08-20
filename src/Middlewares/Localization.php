<?php

namespace DNT\Localization\Middlewares;

use Closure;
use DNT\Localization\Contracts\LocalizationContract;
use Illuminate\Support\Facades\App;

class Localization
{
    protected $location;

    public function __construct(LocalizationContract $location)
    {
        $this->location = $location;
    }

    public function handle($request, Closure $next)
    {
        $locale = $request->route()->getAction()['localization'] ?? session($this->location->getNameAction());
        if ($locale) {
            App::setLocale($locale);
        }
        return $next($request);
    }
}