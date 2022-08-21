<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Support;

use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\ProductRepository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Collection;

class NotificationRelatedProducts
{
    /** @return Collection<int, array{id: int, title: string, link: string, image: string}> */
    public static function get($count = 3): Collection
    {
        return (new ProductRepository())
            ->random()
            ->take($count)
            ->map(fn (ShopProduct $product) => [
                'id' => (int) $product->id,
                'title' => (string) $product->title,
                'link' => Container::getInstance()->make(Repository::class)->get('app.url').$product->link,
                'image' => (string) $product->first_image,
            ]);
    }
}
