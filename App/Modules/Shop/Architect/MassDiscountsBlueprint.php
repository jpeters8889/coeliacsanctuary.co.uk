<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

use Carbon\Carbon;
use JPeters\Architect\Plans\Group;
use JPeters\Architect\Plans\Boolean;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Textfield;
use JPeters\Architect\Blueprints\Blueprint;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopMassDiscount;

class MassDiscountsBlueprint extends Blueprint
{
    public function blueprintSite(): string
    {
        return 'Shop';
    }

    public function blueprintName(): string
    {
        return 'Mass Discounts';
    }

    public function blueprintRoute(): string
    {
        return 'shop-mass-discounts';
    }

    public function model(): string
    {
        return ShopMassDiscount::class;
    }

    public function plans(): array
    {
        return [
            Textfield::generate('title'),
            Textfield::generate('percentage'),
            DateTime::generate('start_at')->setDefault(Carbon::now()->toIso8601String()),
            DateTime::generate('end_at')->setDefault(Carbon::now()->addWeek()->toIso8601String()),
            DateTime::generate('created_at')->hideOnForms(),

            Group::generate('categories')
                ->hideOnIndex()
                ->setPivotRelationship('assignedCategories')
                ->plans($this->getCategories()),
        ];
    }

    public function getCategories(): array
    {
        return ShopCategory::withLiveProducts()
            ->orderBy('title')
            ->get()
            ->transform(static function (ShopCategory $category) {
                return Boolean::generate($category->id, $category->title)->setDefault('0');
            })
            ->toArray();
    }
}
