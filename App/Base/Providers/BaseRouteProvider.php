<?php

declare(strict_types=1);

namespace Coeliac\Base\Providers;

use Illuminate\Routing\Router;
use Illuminate\Container\Container;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;

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
            $router->middleware('web')
                ->group(function () use ($router, $map) {
                    return require base_path($this->path.$map.'.php');
                });
        }
    }
}
