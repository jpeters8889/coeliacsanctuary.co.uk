<?php

declare(strict_types=1);

namespace Coeliac\Common\Traits;

use Coeliac\Common\Filters\AbstractFilter;
use Illuminate\Container\Container;
use Illuminate\Http\Request;

trait Filterable
{
    /** @var AbstractFilter */
    protected $filterable;

    /** @param class-string<AbstractFilter> $filterClass */
    public function filter(string $filterClass = null): static
    {
        if (!$filterClass) {
            $thisNamespace = explode('\\', self::class);
            array_pop($thisNamespace);
            $module = array_pop($thisNamespace);

            $filterNamespace = array_merge($thisNamespace, [
                $module,
                'Filters',
                $module . 'Filter',
            ]);

            $filterClass = implode('\\', $filterNamespace);
        }

        $this->filterable = new $filterClass(Container::getInstance()->make(Request::class));

        return $this;
    }
}
