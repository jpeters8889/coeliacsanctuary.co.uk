<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Events;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;
use Illuminate\Support\Collection;

class PrepareWhereToEatReviewImages
{
    public function __construct(protected WhereToEatReview $review, protected array $imageIds)
    {
        //
    }

    public function review(): WhereToEatReview
    {
        return $this->review;
    }

    public function images(): Collection
    {
        return new Collection($this->imageIds);
    }
}
