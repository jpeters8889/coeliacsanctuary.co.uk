<?php

namespace Database\Factories;

use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\ScrapbookItem;
use Coeliac\Modules\Member\Traits\CanBeAddedToScrapbook;

class ScrapbookItemFactory extends Factory
{
    protected $model = ScrapbookItem::class;

    public function definition()
    {
        return [
            'item_type' => self::factoryForModel(Blog::class),
            'item_id' => 1,
        ];
    }

    public function in(Scrapbook $scrapbook)
    {
        return $this->state(fn () => [
            'scrapbook_id' => $scrapbook->id,
        ]);
    }
}
