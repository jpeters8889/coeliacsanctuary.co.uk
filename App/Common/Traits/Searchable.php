<?php

declare(strict_types=1);

namespace Coeliac\Common\Traits;

use Illuminate\Http\Request;
use Illuminate\Container\Container;

trait Searchable
{
    protected bool $useSearch = false;

    protected function performSearch(string $model): array|null
    {
        if (!$this->useSearch) {
            return null;
        }

        $request = Container::getInstance()->make(Request::class);

        if ($request->has('search')) {
            return $model::search($request->get('search'))->get()->pluck(['id'])->toArray();
        }

        return null;
    }

    public function search(): static
    {
        $this->useSearch = true;

        return $this;
    }
}
