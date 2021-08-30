<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Coeliac\Common\Models\Image;
use Coeliac\Modules\Shop\ProductRepository;
use Coeliac\Modules\Shop\Response\ShopPage;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopFeedback;
use Coeliac\Modules\Shop\Requests\ProductShowRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Response;

class ProductController extends BaseController
{
    public function __construct(private ShopPage $page)
    {
    }

    public function show(ProductShowRequest $request): Response
    {
        /* @var ShopProduct $product */
        $product = $request->resolveItem([
            /** @phpstan-ignore-next-line  */
            'images' => fn (Relation $query) => $query->whereIn('image_category_id', [Image::IMAGE_CATEGORY_GENERAL, Image::IMAGE_CATEGORY_SHOP_PRODUCT])
        ]);

        abort_if(!$product instanceof ShopProduct || !$product->variants instanceof Collection, 404, 'Sorry, this product can\'t be found');

        /** @var ShopCategory $category */
        $category = $product->categories()->first();

        $feedback = ShopFeedback::query()->with('product')->inRandomOrder()->take(3)->get();

        return $this->page
            ->breadcrumbs([
                [
                    'link' => '/shop',
                    'title' => 'Shop',
                ],
                [
                    'link' => $category->link,
                    'title' => $category->title,
                ],
            ], $product->title)
            ->setPageTitle($product->title.' | Shop')
            ->setMetaDescription($product->meta_description)
            ->setMetaKeywords(explode(',', $product->meta_keywords))
            ->setSocialImage($product->first_image)
            ->render('modules.shop.product', compact('product', 'category', 'feedback'));
    }

    public function get(ProductRepository $repository, mixed $id): array
    {
        abort_if(!$product = $repository->setWiths(['variants'])->get($id), 404);

        /** @var ShopProduct $product */
        $product->makeVisible(['variants']);
        /** @phpstan-ignore-next-line  */
        $product->variants->makeVisible('quantity');

        return ['data' => $product];
    }
}
