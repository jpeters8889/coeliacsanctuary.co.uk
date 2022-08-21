<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Models\Image;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\ProductRepository;

class ProductImagesController extends BaseController
{
    public function get(ProductRepository $repository, mixed $id): array
    {
        /** @var ?ShopProduct $product */
        $product = $repository->get($id);

        abort_if(! $product, 404);

        return [
            'images' => $product->images
                ->whereIn('image_category_id', [Image::IMAGE_CATEGORY_GENERAL, Image::IMAGE_CATEGORY_SHOP_PRODUCT])
                ->pluck('image.image_url'),
        ];
    }
}
