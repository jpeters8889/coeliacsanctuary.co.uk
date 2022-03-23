<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

use Illuminate\Validation\Rule;
use NumberToWords\Legacy\Numbers\Words\Locale\Ru;

class OpeningTimesField extends Processor
{
    protected static array $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    public static function validationRules(): array
    {
        return [
            'value' => ['required', 'array', 'size:7'],
            'value.*' => ['array'],
            'value.*.key' => ['required', Rule::in(static::$days)],
            'value.*.label' => ['required', Rule::in(array_map(fn($day) => ucfirst($day), static::$days))],
            'value.*.start' => ['required', 'array', 'size:2'],
            'value.*.start.0' => ['required', 'numeric', 'min:0', 'max:23'],
            'value.*.start.1' => ['required', 'numeric', Rule::in([0, 15, 30, 45])],
            'value.*.end' => ['required', 'array', 'size:2'],
            'value.*.end.0' => ['required', 'numeric', 'min:0', 'max:23'],
            'value.*.end.1' => ['required', 'numeric', Rule::in([0, 15, 30, 45])],
        ];
    }

    protected function transformFieldValue(): string
    {
        return json_encode($this->value);
    }
}
