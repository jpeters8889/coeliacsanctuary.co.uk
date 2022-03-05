<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\CollectionItems;

use Illuminate\Http\Request;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\Collection\Items\Item;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\Collection\Models\CollectionItem;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class ApiHandler
{
    public function search(Request $request)
    {
        $column = 'title';

        switch ($request->input('type')) {
            case 'blogs':
            default:
                $model = Blog::class;
                break;
            case 'recipes':
                $model = Recipe::class;
                break;
            case 'wte':
                $model = WhereToEat::class;
                $column = 'name';
                break;
            case 'shop':
                $model = ShopProduct::class;
                break;
        }

        /** @var CollectionItem $item */
        $item = new CollectionItem();

        return [
            'results' => $model::query()
                ->where($column, 'LIKE', "%{$request->input('term')}%")
                ->take(10)
                ->orderBy($column)
                ->get()
                ->filter(function ($model) {
                    if (!$model instanceof ShopProduct) {
                        return (bool) $model->live === true;
                    }

                    return true;
                })
                ->transform(function ($model) use ($item) {
                    $item->item()->associate($model);

                    return Item::resolve($item)->toArray();
                })
                ->values(),
        ];
    }
}
