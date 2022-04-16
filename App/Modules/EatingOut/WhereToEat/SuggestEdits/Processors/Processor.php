<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

abstract class Processor
{
    public function __construct(protected mixed $value)
    {
        //
    }

    abstract public static function validationRules(): array;

    public static function processField(mixed $value): string
    {
        return (new static($value))->transformFieldValue();
    }

    protected function transformFieldValue(): string
    {
        return $this->value;
    }

    abstract public function computeCurrentValue(WhereToEat $eatery): string|null;

    public function displaySuggestedValue(): string
    {
        return $this->value;
    }
}
