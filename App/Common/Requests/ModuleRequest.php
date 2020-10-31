<?php

declare(strict_types=1);

namespace Coeliac\Common\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Coeliac\Common\Repositories\AbstractRepository;

abstract class ModuleRequest extends FormRequest
{
    public function rules()
    {
        return [];
    }

    abstract protected function repository(): AbstractRepository;

    protected function identifier()
    {
        return 'slug';
    }

    public function resolveItem($withs = [])
    {
        return $this->repository()
            ->setWiths($withs)
            ->get($this->route($this->identifier()), $this->identifier());
    }
}
