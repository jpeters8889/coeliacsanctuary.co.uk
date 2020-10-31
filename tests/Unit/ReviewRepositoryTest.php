<?php

declare(strict_types=1);

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Tests\Abstracts\RepositoryTest;
use Tests\Traits\CreatesWhereToEat;
use Coeliac\Modules\EatingOut\Reviews\Repository;
use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class ReviewRepositoryTest extends RepositoryTest
{
    use CreatesWhereToEat;
    use HasImages;

    protected WhereToEat $whereToEat;

    protected function factoryParameters(): array
    {
        if (!isset($this->whereToEat)) {
            $this->whereToEat = $this->createWhereToEat();
        }

        return [
            'wheretoeat_id' => $this->whereToEat->id,
        ];
    }

    protected function loadRepository(): AbstractRepository
    {
        return new Repository();
    }

    protected function model(): string
    {
        return Review::class;
    }

    /** @test */
    public function it_is_ordered_by_newest_first()
    {
        $latest = $this->models[count($this->models) - 1];
        $latest->created_at = Carbon::now()->addMinutes(5);
        $latest->save();

        $this->assertTrue(
            $latest->is($this->repository->all()->first())
        );
    }

    /** @test */
    public function it_has_the_images_included()
    {
        $this->models[0]->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER);

        $this->assertNotNull($this->repository->get(1)->images);
        $this->assertNotNull($this->repository->get(1)->main_image);
    }
}
