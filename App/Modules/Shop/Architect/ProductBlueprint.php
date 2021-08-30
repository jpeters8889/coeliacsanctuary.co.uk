<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

use Coeliac\Common\Models\Image;
use JPeters\Architect\Plans\Label;
use JPeters\Architect\Plans\Select;
use JPeters\Architect\Plans\Boolean;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Textarea;
use JPeters\Architect\Plans\Textfield;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopShippingMethod;
use Coeliac\Architect\Plans\ImageManager\Plan as ImagePlan;
use Coeliac\Architect\Plans\ShopProductPrices\Plan as ProductPrices;
use Coeliac\Architect\Plans\ShopProductSoldCount\Plan as ProductsSold;
use Coeliac\Architect\Plans\ShopProductVariants\Plan as ProductVariants;

class ProductBlueprint extends Blueprint
{
    public function blueprintSite(): string
    {
        return 'Shop';
    }

    public function blueprintName(): string
    {
        return 'Products';
    }

    public function model(): string
    {
        return ShopProduct::class;
    }

    public function plans(): array
    {
        return [
            Label::generate('category_title')
                ->hideOnForms(),

            Textfield::generate('title'),

            ImagePlan::generate('images')
                ->hideOnIndex()
                ->setImageDirectory('products')
                ->setDefaultImageCategory(Image::IMAGE_CATEGORY_SHOP_PRODUCT),

            Select::generate('categories')
                ->isInRelationship('categories')
                ->findFromPivot('category_id')
                ->options($this->getCategories())
                ->enableMultiSelect()
                ->defer()
                ->hideOnIndex(),

            Textarea::generate('description')
                ->hideOnIndex(),

            Textarea::generate('architect_body', 'Long Description')
                ->rows(15)
                ->hideOnIndex(),

            ProductPrices::generate('price'),

            ProductVariants::generate('variants'),

            Select::generate('shipping_method_id', 'Shipping Method')
                ->hideOnIndex()
                ->options($this->shippingOptions()),

            Textfield::generate('meta_keywords')
                ->hideOnIndex(),

            Textarea::generate('meta_description')
                ->rows(2)
                ->hideOnIndex(),

            ProductsSold::generate('total_sold')
                ->hideOnForms(),

            Boolean::generate('live')
                ->hideOnForms(),

            Boolean::generate('pinned')
                ->hideOnIndex(),

            DateTime::generate('created_at')
                ->hideOnForms(),
        ];
    }

    protected function shippingOptions()
    {
        return ShopShippingMethod::query()
            ->get()
            ->mapWithKeys(static function (ShopShippingMethod $method) {
                return [$method->id => $method->shipping_method];
            })
            ->toArray();
    }

    protected function getCategories()
    {
        return ShopCategory::query()
            ->get()
            ->mapWithKeys(static function (ShopCategory $category) {
                return [$category->id => $category->title];
            })
            ->toArray();
    }

    public function getData(): Builder
    {
        return parent::getData()
            ->with(['prices', 'images', 'images.category'])
            ->selectRaw(implode(',', [
                'shop_products.*',
                'shop_categories.title category_title',
                'if((exists(select * from shop_product_variants where live = 1 and shop_product_variants.product_id = shop_products.id)), 1, 0) live',
                '(select coalesce(sum(shop_order_items.quantity), 0) total_sold from shop_order_items
                left join shop_orders on shop_orders.id = shop_order_items.order_id
                where shop_orders.state_id IN (2,3,4,5) AND shop_order_items.product_id = shop_products.id) total_sold',
            ]))
            ->leftJoin('shop_product_categories', 'shop_product_categories.product_id', '=', 'shop_products.id')
            ->leftJoin('shop_categories', 'shop_product_categories.category_id', '=', 'shop_categories.id');
    }

    public function makeVisible(): array
    {
        return [
            'category_title',
            'meta_description',
            'live',
            'total_sold',
        ];
    }

    public function ordering(): array
    {
        return [
            ['category_title', 'asc'],
            ['title', 'asc'],
        ];
    }

    public function blueprintRoute(): string
    {
        return 'shop-products';
    }
}
