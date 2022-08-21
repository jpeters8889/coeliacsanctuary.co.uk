<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

abstract class Processor
{
    final public function __construct(protected mixed $value)
    {
        //
    }

    abstract public static function validationRules(): array;

    public static function processField(mixed $value): string | int
    {
        return (new static($value))->transformFieldValue();
    }

    protected function transformFieldValue(): string | int
    {
        return $this->value;
    }

    abstract public function computeCurrentValue(WhereToEat $eatery): string|null;

    public function displaySuggestedValue(): string
    {
        return $this->value;
    }
}
