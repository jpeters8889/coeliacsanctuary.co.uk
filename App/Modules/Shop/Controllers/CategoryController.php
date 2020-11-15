<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Modules\Shop\Response\ShopPage;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\CategoryRepository;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Requests\CategoryShowRequest;

class CategoryController extends BaseController
{
    private Page $page;

    private CategoryRepository $repository;

    public function __construct(ShopPage $page, CategoryRepository $repository)
    {
        $this->page = $page;
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->page
            ->breadcrumbs([], 'Shop')
            ->setPageTitle('Shop - Travel Cards, Wristbands and more')
            ->setMetaDescription('Coeliac Sanctuary gluten free and coeliac travel cards, wristbands, stickers and other helpful products for Coeliacs.')
            ->setMetaKeywords([
                'Gluten free merchandise', 'coeliac sanctuary shop', 'coeliac travel cards', 'gluten free travel cards',
                'travelling abroad', 'gluten free abroad', 'coeliac travel', 'gluten free travel', 'coeliac wristbands',
                'gluten free stickers', 'gluten free wristbands', 'gluten free waterproof stickers', 'coeliac shop',
            ])
            ->render('modules.shop.index', [
                'categories' => $this->repository->all(),
            ]);
    }

    public function show(CategoryShowRequest $request)
    {
        /* @var ShopCategory $category */
        $category = $request->resolveItem();

        abort_if(!$category, 404, 'Sorry, this category can\'t be found');

        return $this->page
            ->breadcrumbs([
                [
                    'title' => 'Shop',
                    'link' => 'shop',
                ],
            ], $category->title)
            ->setPageTitle($category->title.' | Shop')
            ->setMetaDescription($category->meta_description)
            ->setMetaKeywords(explode(',', $category->meta_keywords))
            ->setSocialImage($category->first_image)
            ->render('modules.shop.category', [
                'category' => $category,
                'products' => $request->products(),
            ]);
    }
}
