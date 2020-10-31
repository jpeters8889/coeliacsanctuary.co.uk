<?php

declare(strict_types=1);

namespace Coeliac\Common\Traits;

use Illuminate\Http\Request;
use Illuminate\Container\Container;
use Coeliac\Common\Filters\AbstractFilter;

trait Filterable
{
    /** @var AbstractFilter */
    protected $filterable;

    public function filter()
    {
        $thisNamespace = explode('\\', self::class);
        array_pop($thisNamespace);
        $module = array_pop($thisNamespace);

        $filterNamespace = array_merge($thisNamespace, [
            $module,
            'Filters',
            $module.'Filter',
        ]);

        $filterClass = implode('\\', $filterNamespace);

        $this->filterable = new $filterClass(Container::getInstance()->make(Request::class));

        return $this;
    }
}
