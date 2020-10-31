<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\Models\ShopPostageCountry;
use Coeliac\Modules\Shop\Requests\CountrySelectRequest;

class CountryController extends BaseController
{
    public function index()
    {
        return ShopPostageCountry::query()
            ->orderBy('country')
            ->get()
            ->transform(static function (ShopPostageCountry $country) {
                return [
                'value' => $country->id,
                'label' => $country->country,
            ];
            });
    }

    public function update(CountrySelectRequest $request, Basket $basket)
    {
        abort_if(!$basket->resolve(), 400);

        $basket->model()->update(['postage_country_id' => $request->input('country')]);

        return ['data' => 'ok'];
    }
}
