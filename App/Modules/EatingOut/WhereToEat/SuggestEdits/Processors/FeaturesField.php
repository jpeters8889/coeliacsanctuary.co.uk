<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

class FeaturesField extends Processor
{
    public static function validationRules(): array
    {
        return [
            'value' => ['required', 'array'],
            'value.*' => ['array'],
            'value.*.key' => ['required', 'exists:wheretoeat_features,id'],
            'value.*.label' => ['required'],
            'value.*.selected' => ['required', 'boolean'],
        ];
    }

    protected function transformFieldValue(): string
    {
        return json_encode($this->value);
    }
}
