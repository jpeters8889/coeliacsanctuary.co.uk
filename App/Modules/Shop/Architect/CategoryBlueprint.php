<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

use Coeliac\Common\Models\Image;
use JPeters\Architect\Plans\Label;
use Illuminate\Container\Container;
use Illuminate\Database\Connection;
use JPeters\Architect\Plans\Textarea;
use JPeters\Architect\Plans\Textfield;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use JPeters\Architect\Blueprints\Blueprint;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Architect\Plans\ImageManager\Plan;

class CategoryBlueprint extends Blueprint
{
    public function blueprintSite(): string
    {
        return 'Shop';
    }

    public function blueprintName(): string
    {
        return 'Categories';
    }

    public function model(): string
    {
        return ShopCategory::class;
    }

    public function getData(): Builder
    {
        return parent::getData()->select('*')
            ->selectSub(
                Container::getInstance()->make(Connection::class)->table('shop_product_categories')
                    ->selectRaw('count(*)')
                    ->leftJoin('shop_product_variants', function (JoinClause $join) {
                        return $join->on('shop_product_variants.product_id', '=', 'shop_product_categories.product_id');
                    })
                    ->whereRaw('shop_product_categories.category_id = shop_categories.id'),
                'number_of_products'
            )
            ->selectSub(
                Container::getInstance()->make(Connection::class)->table('shop_product_categories')
                    ->selectRaw('count(*)')
                    ->leftJoin('shop_product_variants', function (JoinClause $join) {
                        return $join->on('shop_product_variants.product_id', '=', 'shop_product_categories.product_id')
                            ->where('shop_product_variants.live', true);
                    })
                    ->whereRaw('shop_product_categories.category_id = shop_categories.id')
                    ->where('shop_product_variants.live', 1),
                'number_of_live_products'
            );
    }

    public function plans(): array
    {
        return [
            Textfield::generate('title'),

            Textarea::generate('description'),

            Label::generate('number_of_products', 'Products')->hideOnForms(),

            Label::generate('number_of_live_products', 'Live Products')->hideOnForms(),

            Plan::generate('images')
                ->hideOnIndex()
                ->setImageDirectory('categories')
                ->setDefaultImageCategory(Image::IMAGE_CATEGORY_SHOP_CATEGORY),

            Textfield::generate('meta_keywords')->hideOnIndex(),

            Textarea::generate('meta_description')
                ->rows(2)
                ->hideOnIndex(),
        ];
    }

    public function blueprintRoute(): string
    {
        return 'shop-categories';
    }
}
