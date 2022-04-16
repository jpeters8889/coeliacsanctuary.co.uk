<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatSuggestedEdit;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\SuggestEditRequest;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\Processor;

class UpdateHandler
{
    public function __construct(protected SuggestEditRequest $request)
    {
        //
    }

    public function process()
    {
        WhereToEatSuggestedEdit::query()->create([
            'wheretoeat_id' => $this->request->eatery()->id,
            'field' => $this->request->input('field'),
            'value' => $this->resolveFieldProcessor(),
            'ip' => $this->request->ip(),
        ]);
    }

    protected function resolveFieldProcessor(): string
    {
        $processorMaps = WhereToEatSuggestedEdit::processorMaps();

        /** @var class-string<Processor> $class */
        $class = $processorMaps[$this->request->input('field')];

        return $class::processField($this->request->input('value'));
    }
}
