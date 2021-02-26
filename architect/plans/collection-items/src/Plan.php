<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\CollectionItems;

use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Database\Eloquent\Model;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\Collection\Items\Item;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Collection\Models\Collection;
use JPeters\Architect\Plans\Plan as ArchitectPlan;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\Collection\Models\CollectionItem;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class Plan extends ArchitectPlan
{
    public bool $deferUpdate = true;

    public function vuePrefix(): string
    {
        return 'collection-items';
    }

    public function hasDatabaseColumn(): bool
    {
        return false;
    }

    public function getCurrentValue(Model $model)
    {
        /* @var Collection $model */
        /* @var EloquentCollection<CollectionItem> $items */
        $items = $model->items;

        return $items
            ->sortBy('position')
            ->transform(fn (CollectionItem $item) => Item::resolve($item)->toArray())
            ->values();
    }

    public function handleUpdate(Model $model, $column, $value)
    {
        /* @var Collection $model */
        $model->items()->delete();

        foreach (json_decode($value, true) as $item) {
            $model->items()->create([
                'item_type' => $this->getItemModel($item['type']),
                'item_id' => $item['id'],
                'description' => $item['description'],
                'position' => $item['position'],
            ]);
        }

        $model->touch();
    }

    protected function getItemModel(string $item): string
    {
        if ($item === 'blog') {
            return Blog::class;
        }

        if ($item === 'review') {
            return Review::class;
        }

        if ($item === 'recipe') {
            return Recipe::class;
        }

        if ($item === 'eatery') {
            return WhereToEat::class;
        }

        return ShopProduct::class;
    }
}
