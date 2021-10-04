<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Members;

use Tests\TestCase;
use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\ScrapbookItem;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;

class ScrapbookTest extends TestCase
{
    protected Scrapbook $scrapbook;

    protected function setUp(): void
    {
        parent::setUp();

        $this->scrapbook = $this->create(Scrapbook::class);
    }

    /** @test */
    public function itBelongsToAUser()
    {
        $this->assertNotNull($this->scrapbook->user);
        $this->assertInstanceOf(User::class, $this->scrapbook->user);
    }

    /** @test */
    public function itCanHaveItems()
    {
        $this->assertCount(0, $this->scrapbook->refresh()->items);

        $this->build(ScrapbookItem::class)
            ->in($this->scrapbook)
            ->for($this->create(Blog::class), 'item')
            ->create();

        $this->assertCount(1, $this->scrapbook->refresh()->items);
    }

    /** @test */
    public function itCanAccessTheIndividualItem()
    {
        $this->build(ScrapbookItem::class)
            ->in($this->scrapbook)
            ->for($this->create(Blog::class), 'item')
            ->create();

        $this->assertInstanceOf(Blog::class, $this->scrapbook->fresh()->items[0]->item);
    }

    /**
     * @test
     * @dataProvider itemDataProvider
     */
    public function itCanHaveItemsAdded($item)
    {
        $this->build(ScrapbookItem::class)
            ->in($this->scrapbook)
            ->for($this->create($item), 'item')
            ->create();

        $this->scrapbook->refresh();

        $this->assertCount(1, $this->scrapbook->items);
        $this->assertInstanceOf($item, $relation = $this->scrapbook->items[0]->item);
        $this->assertTrue($item::query()->first()->is($relation));
    }

    /**
     * @test
     * @dataProvider itemDataProvider
     */
    public function itCanHaveItemsAddedViaAHelperMethod($class)
    {
        /** @var BaseModel $item */
        $item = $this->create($class);

        $item->addToScrapbook($this->scrapbook);

        $this->scrapbook->refresh();

        $this->assertCount(1, $this->scrapbook->items);
        $this->assertInstanceOf($class, $relation = $this->scrapbook->items[0]->item);
        $this->assertTrue($item->is($relation));
    }

    public function itemDataProvider(): array
    {
        return [
            [Blog::class],
            [Recipe::class],
            [Review::class],
        ];
    }
}
