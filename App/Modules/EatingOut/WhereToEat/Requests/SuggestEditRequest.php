<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatSuggestedEdit;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\Processor;
use Illuminate\Validation\Rule;

class SuggestEditRequest extends ApiFormRequest
{
    protected WhereToEat $eatery;

    protected function resolveEatery()
    {
        $this->eatery = (new Repository())
            ->setWiths(['venueType', 'cuisine', 'openingTimes', 'features'])
            ->getOrFail($this->route('id'));
    }

    public function eatery(): WhereToEat
    {
        if (!isset($this->eatery)) {
            $this->resolveEatery();
        }

        return $this->eatery;
    }

    /*** @return class-string<Processor> | null */
    protected function resolveProcessorClass(): string|null
    {
        return WhereToEatSuggestedEdit::processorMaps()[$this->input('field')] ?? null;
    }

    public function rules(): array
    {
        $this->resolveEatery();

        $rules = ['field' => ['bail', 'required', Rule::in($this->editableFields())]];

        if ($this->resolveProcessorClass()) {
            $additionalRules = $this->resolveProcessorClass()::validationRules();

            if (array_key_first($additionalRules) === 'value') {
                return array_merge($rules, $additionalRules);
            }

            $rules['value'] = $additionalRules;
        }

        return $rules;
    }

    protected function editableFields(): array
    {
        return array_keys(WhereToEatSuggestedEdit::processorMaps());
    }
}
