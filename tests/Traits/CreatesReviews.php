<?php

declare(strict_types=1);

namespace Tests\Traits;

use Coeliac\Modules\EatingOut\Reviews\Models\Review;

trait CreatesReviews
{
    protected function createReview($reviewParams = [])
    {
        $wte = $this->createWhereToEat();

        return factory(Review::class)->create(array_merge(['wheretoeat_id' => $wte->id], $reviewParams));
    }
}
