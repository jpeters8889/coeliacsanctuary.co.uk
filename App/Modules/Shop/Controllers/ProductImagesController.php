<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\ProductRepository;
use Coeliac\Base\Controllers\BaseController;

class ProductImagesController extends BaseController
{
    public function get(ProductRepository $repository, $id)
    {
        /** @var ?ShopProduct $product */
        $product = $repository->get($id);

        abort_if(!$product, 404);

        return [
            'images' => $product->images->pluck('image.image_url'),
        ];
    }
}
