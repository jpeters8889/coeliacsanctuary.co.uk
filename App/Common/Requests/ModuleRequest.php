<?php

declare(strict_types=1);

namespace Coeliac\Common\Requests;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Foundation\Http\FormRequest;
use Coeliac\Common\Repositories\AbstractRepository;

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

    public function resolveItem(array $withs = []): ?BaseModel
    {
        return $this->repository()
            ->setWiths($withs)
            ->get($this->route($this->identifier()), $this->identifier());
    }
}
