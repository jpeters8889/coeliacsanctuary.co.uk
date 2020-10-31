<?php

declare(strict_types=1);

namespace Coeliac\Common\Traits;

use Illuminate\Http\Request;
use Illuminate\Container\Container;

trait Searchable
{
    protected $useSearch = false;

    protected function performSearch($model)
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

    public function search()
    {
        $this->useSearch = true;

        return $this;
    }
}
