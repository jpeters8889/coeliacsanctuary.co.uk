<?php

declare(strict_types=1);

namespace Coeliac\Common\Requests;

use Coeliac\Common\Repositories\AbstractRepository;
use Illuminate\Foundation\Http\FormRequest;

/** @template TModel of \Coeliac\Base\Models\BaseModel */
abstract class ModuleRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    abstract protected function repository(): AbstractRepository;

    protected function identifier(): string
    {
        return 'slug';
    }

    /** @return TModel | null */
    public function resolveItem(array $withs = [])
    {
        return $this->repository()
            ->setWiths($withs)
            ->get($this->route($this->identifier()), $this->identifier());
    }
}
