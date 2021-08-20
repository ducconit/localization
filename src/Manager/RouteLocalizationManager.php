<?php

namespace DNT\Localization\Manager;

use DNT\Localization\Contracts\LocalizationContract;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Arr;

class RouteLocalizationManager implements LocalizationContract
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var Repository
     */
    private $config;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->config = $container['config'];
    }

    /**
     * List locale support contains locale default application
     */
    public function localeSupport(): array
    {
        $default = $this->container->getLocale();

        $localeConfig = $this->config['localization.support'];

        array_push($localeConfig, $default);

        $result = array_unique(Arr::where($localeConfig, function ($locale) {
            return $locale;
        }));

        if (count($result) < 1) {
            throw new \Exception('Hiện tại không hỗ trợ ngôn ngữ nào');
        }

        return $result;
    }

    /**
     * get name action route
     */
    public function getNameAction(): string
    {
        return $this->config['localization.name_action'];
    }

    /**
     * Resolve middleware if exists
     */
    public function pushMiddlewares()
    {
        $middlewares = $this->getMiddleware();

        if (!$middlewares) {
            return;
        }

        if (is_array($middlewares)) {
            foreach ($middlewares as $middleware) {
                $this->pushMiddleware($middleware);
            }
            return;
        }

        $this->pushMiddleware($middlewares);
    }

    private function pushMiddleware(string $middleware)
    {
        $kernel = $this->container[Kernel::class];
        $kernel->appendMiddlewareToGroup('web', $middleware);
    }

    public function getMiddleware()
    {
        return $this->config['localization.middleware'];
    }
}