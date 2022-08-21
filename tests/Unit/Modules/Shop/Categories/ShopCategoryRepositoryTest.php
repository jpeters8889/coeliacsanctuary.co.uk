<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Categories;

use Coeliac\Common\Models\Image;
use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Modules\Shop\CategoryRepository;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Tests\Abstracts\RepositoryTest;
use Tests\Traits\HasImages;

class ShopCategoryRepositoryTest extends RepositoryTest
{
    use HasImages;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        foreach ($this->models as $model) {
            $model->products()->attach($this->build(ShopProduct::class)
                ->has($this->build(ShopProductVariant::class), 'variants')
                ->create());
        }
    }

    protected function loadRepository(): AbstractRepository
    {
        return new CategoryRepository();
    }

    protected function model(): string
    {
        return ShopCategory::class;
    }

    /** @test */
    public function itHasTheImagesIncluded()
    {
        $this->models[0]->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_CATEGORY);

        $this->assertNotNull($this->repository->get(1)->images);
    }
}
