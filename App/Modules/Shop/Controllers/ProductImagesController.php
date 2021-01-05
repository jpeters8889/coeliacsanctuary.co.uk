<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Coeliac\Common\Models\Image;
use Coeliac\Common\Models\ImageAssociations;
use Coeliac\Common\Models\ImageCategory;
use Coeliac\Modules\Shop\ProductRepository;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\Models\ShopProduct;

class ProductImagesController extends BaseController
{
    public function get(ProductRepository $repository, $id)
    {
        /** @var ?ShopProduct $product */
        $product = $repository->get($id);

        abort_if(!$product, 404);

        return [
            'images' => $product->images
                ->where('image_category_id', Image::IMAGE_CATEGORY_GENERAL)
                ->pluck('image.image_url'),
        ];
    }
}
