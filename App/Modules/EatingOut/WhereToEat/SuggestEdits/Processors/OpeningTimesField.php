<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OpeningTimesField extends Processor
{
    protected static array $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    public static function validationRules(): array
    {
        return [
            'value' => ['required', 'array', 'size:7'],
            'value.*' => ['array'],
            'value.*.key' => ['required', Rule::in(static::$days)],
            'value.*.label' => ['required', Rule::in(array_map(fn ($day) => ucfirst($day), static::$days))],
            'value.*.start' => ['required', 'array', 'size:2'],
            'value.*.start.0' => ['present', 'nullable', 'numeric', 'min:0', 'max:23'],
            'value.*.start.1' => ['present', 'nullable', 'numeric', Rule::in([0, 15, 30, 45])],
            'value.*.end' => ['required', 'array', 'size:2'],
            'value.*.end.0' => ['present', 'nullable', 'numeric', 'min:0', 'max:23'],
            'value.*.end.1' => ['present', 'nullable', 'numeric', Rule::in([0, 15, 30, 45])],
        ];
    }

    protected function transformFieldValue(): string
    {
        return json_encode($this->value);
    }

    public function computeCurrentValue(WhereToEat $eatery): string|null
    {
        $openingTimes = $eatery->openingTimes;

        if ($openingTimes === null) {
            return null;
        }

        return collect(self::$days)
            ->map(fn ($day) => [
                'key' => $day,
                'label' => Str::title($day),
                'closed' => $openingTimes->{$day . '_start'} === null,
                'start' => $openingTimes->formatTime($day . '_start'),
                'end' => $openingTimes->formatTime($day . '_end'),
            ])
            ->toJson();
    }
}
