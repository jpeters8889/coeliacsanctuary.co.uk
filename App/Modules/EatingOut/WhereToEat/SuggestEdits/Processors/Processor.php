<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

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
}
