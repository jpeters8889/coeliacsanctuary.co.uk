<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Products;

use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Tests\Abstracts\RepositoryTest;
use Coeliac\Modules\Shop\ProductRepository;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Common\Repositories\AbstractRepository;

class ShopProductRepositoryTest extends RepositoryTest
{
    use HasImages;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        foreach ($this->models as $model) {
            /* @var ShopProduct $model */
            $model->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);
            $this->build(ShopProductVariant::class)->in($model)->create();
        }
    }

    protected function loadRepository(): AbstractRepository
    {
        return new ProductRepository();
    }

    protected function model(): string
    {
        return ShopProduct::class;
    }

    /** @test */
    public function itHasTheImagesIncluded()
    {
        $this->models[0]->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_CATEGORY);

        $this->assertNotNull($this->repository->get(1)->images);
    }
}
