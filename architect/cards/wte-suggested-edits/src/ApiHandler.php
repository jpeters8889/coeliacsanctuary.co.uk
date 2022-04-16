<?php

namespace Coeliac\Architect\Cards\WteSuggestedEdits;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatSuggestedEdit;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\Processor;
use Illuminate\Support\Str;

class ApiHandler
{
    public function get($id)
    {
        /** @var WhereToEatSuggestedEdit $suggestedEdit */
        $suggestedEdit = WhereToEatSuggestedEdit::query()
            ->with(['eatery', 'eatery.town', 'eatery.county', 'eatery.country'])
            ->find($id);

        /** @var Processor $processor */
        $class = WhereToEatSuggestedEdit::processorMaps()[$suggestedEdit->field];
        $processor = new $class($suggestedEdit->value);

        return [
            'id' => $suggestedEdit->id,
            'eatery_id' => $suggestedEdit->eatery->id,
            'location' => $suggestedEdit->eatery->full_name,
            'status' => $suggestedEdit->status,
            'field_label' => Str::of($suggestedEdit->field)->studly()->snake(' ')->title(),
            'field' => $suggestedEdit->field,
            'currentValue' => $processor->computeCurrentValue($suggestedEdit->eatery),
            'recommendedValue' => $processor->displaySuggestedValue(),
            'accepted' => $suggestedEdit->accepted,
            'rejected' => $suggestedEdit->rejected,
            'created_at' => $suggestedEdit->created_at->toDateTimeString(),
            'updated_at' => $suggestedEdit->updated_at->toDateTimeString(),
        ];
    }

    public function accept($id)
    {
        WhereToEatSuggestedEdit::query()
            ->find($id)
            ->update(['accepted' => 1]);
    }

    public function reject($id)
    {
        WhereToEatSuggestedEdit::query()
            ->find($id)
            ->update(['rejected' => 1]);
    }
}
