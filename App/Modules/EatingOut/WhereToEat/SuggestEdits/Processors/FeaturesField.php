<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;

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

    public function computeCurrentValue(WhereToEat $eatery): string|null
    {
        $eatery->load('features');

        return WhereToEatFeature::query()
            ->orderBy('feature')
            ->get()
            ->mapWithKeys(fn (WhereToEatFeature $feature) => [
                $feature->feature => collect($eatery->features->pluck('id'))->contains($feature->id),
            ])
            ->toJson();
    }
}
