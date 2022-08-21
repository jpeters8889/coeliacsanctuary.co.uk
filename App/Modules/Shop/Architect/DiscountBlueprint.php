<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Models\ShopDiscountCodeType;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Label;
use JPeters\Architect\Plans\Select;
use JPeters\Architect\Plans\Textfield;

class DiscountBlueprint extends Blueprint
{
    public function blueprintSite(): string
    {
        return 'Shop';
    }

    public function blueprintName(): string
    {
        return 'Discount Codes';
    }

    public function model(): string
    {
        return ShopDiscountCode::class;
    }

    public function plans(): array
    {
        return [
            Textfield::generate('name'),

            Textfield::generate('code'),

            DateTime::generate('start_at')
                ->setDefault(Carbon::now()->toString()),

            DateTime::generate('end_at')
                ->setDefault(Carbon::now()->addMonth()->toString()),

            Label::generate('claims')->hideOnForms(),

            Label::generate('architect_type', 'Type')->hideOnForms(),

            Label::generate('architect_min_spend', 'Min Spend')->hideOnForms(),

            Label::generate('architect_deduction', 'Deduction')->hideOnForms(),

            Textfield::generate('max_claims', 'Max Claims (Leave 0 for unlimited)')
                ->setDefault('0')
                ->hideOnIndex(),

            Textfield::generate('min_spend', 'Min Spend (In Pence! Leave 0 for none)')
                ->setDefault('0')
                ->hideOnIndex(),

            Select::generate('type_id', 'Discount Type')
                ->options(
                    ShopDiscountCodeType::all()
                        ->mapWithKeys(fn (ShopDiscountCodeType $type) => [$type->id => $type->name])
                        ->toArray()
                )
                ->setDefault('1')
                ->hideOnIndex(),

            Textfield::generate('deduction', 'Deduction (In pence for money deduction)')->hideOnIndex(),
        ];
    }

    public function getData(): Builder
    {
        return parent::getData()
            ->selectRaw(implode(',', [
                '*',
                'concat("£", format(min_spend / 100, 2)) architect_min_spend',
                'if(type_id = '.ShopDiscountCodeType::PERCENTAGE.', concat(deduction, "%"), concat("£", format(deduction / 100, 2))) architect_deduction',
                '(select shop_discount_code_types.name from shop_discount_code_types where shop_discount_code_types.id = shop_discount_codes.type_id) architect_type',
                'concat((select count(*) from shop_discount_codes_used where shop_discount_codes_used.discount_id = shop_discount_codes.id), "/", if(max_claims = 0, "Unlim", max_claims)) claims',
            ]));
    }

    public function ordering(): array
    {
        return [
            'id',
            'desc',
        ];
    }

    public function blueprintRoute(): string
    {
        return 'shop-discounts';
    }

    public function searchable(): bool
    {
        return false;
    }
}
