<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Items;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat as WhereToEatModel;

class WhereToEat extends Item
{
    public function toArray(): array
    {
        /** @var WhereToEatModel $eatery */
        $eatery = $this->collectionItem->item;

        return [
            'type' => 'eatery',
            'id' => $eatery->id,
            'title' => $eatery->name,
            'description' => $eatery->info,
            'long_description' => $eatery->info,
            'created_at' => $eatery->created_at,
        ];
    }

    public function render(): string
    {
        return $this->viewFactory->make('modules.collections.items.eatery', [
            'eatery' => $this->collectionItem->item,
            'description' => $this->collectionItem->description,
        ])->render();
    }
}
