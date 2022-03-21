<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

class FeaturesField extends Processor
{
    public static function validationRules(): array
    {
        return [
            'value' => ['required', 'array'],
            'value.*' => ['exists:wheretoeat_features,id'],
        ];
    }

    protected function transformFieldValue(): string
    {
        return json_encode($this->value);
    }
}
