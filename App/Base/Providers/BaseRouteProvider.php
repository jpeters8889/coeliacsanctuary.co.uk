<?php

declare(strict_types=1);

namespace Coeliac\Base\Providers;

use Illuminate\Container\Container;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Routing\Router;

abstract class BaseRouteProvider extends BaseRouteServiceProvider
{
    /**
     * The path to load routes from.
     *
     * @var string
     */
    protected $path = 'App/Common/Routes/';

    /**
     * The files to load from the root $path.
     *
     * @var array
     */
    protected $maps = ['web'];

    /**
     * Map the routes.
     */
    public function map(): void
    {
        /** @var Router $router */
        $router = Container::getInstance()->make(Router::class);

        foreach ($this->maps as $map) {
            $router->middleware('web')->group(fn ($router) => require base_path($this->path.$map.'.php'));
        }
    }

    protected function setRootControllerNamespace()
    {
        //
    }
}
