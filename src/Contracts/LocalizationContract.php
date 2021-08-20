<?php

namespace DNT\Localization\Contracts;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Arr;

interface LocalizationContract
{
    /**
     * List locale support contains locale default application
     */
    public function localeSupport(): array;

}