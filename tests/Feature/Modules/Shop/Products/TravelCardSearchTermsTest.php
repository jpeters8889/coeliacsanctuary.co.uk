<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Products;

use Coeliac\Common\Models\Image;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Coeliac\Modules\Shop\Models\TravelCardSearchTerm;
use Coeliac\Modules\Shop\Models\TravelCardSearchTermHistory;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;
use Tests\Traits\HasImages;

class TravelCardSearchTermsTest extends TestCase
{
    use HasImages;

    /** @var ShopCategory */
    private ShopCategory $category;

    /** @var ShopProduct */
    private ShopProduct $product;

    /** @var ShopProductVariant */
    private ShopProductVariant $variant;

    /** @var ShopProductPrice */
    private ShopProductPrice $price;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = $this->create(ShopCategory::class);

        $this->product = $this->create(ShopProduct::class);
        $this->product->categories()->attach($this->category);

        $this->variant = $this->build(ShopProductVariant::class)
            ->in($this->product)
            ->state(['quantity' => 15])
            ->create();

        // here
        $this->price = $this->build(ShopProductPrice::class)
            ->in($this->product)
            ->state(['price' => 500])
            ->create();

        $this->product->travelCardSearchTerms()
            ->attach($this->create(TravelCardSearchTerm::class, ['term' => 'spanish']));

        $this->product->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);
    }

    public function makeRequest(?string $term = null): TestResponse
    {
        return $this->post('api/shop/travel-card-search', ['term' => $term]);
    }

    /** @test */
    public function itErrorsWithoutASearchTerm(): void
    {
        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function itReturnsOkWithASearchTerm(): void
    {
        $this->makeRequest('foo')->assertOk();
    }

    /** @test */
    public function itReturnsAnEmptyResultsForNoResults(): void
    {
        $request = $this->makeRequest('foo');

        $this->assertEmpty($request->json('results'));
    }

    /** @test */
    public function itReturnsResults(): void
    {
        $request = $this->makeRequest('spanish');

        $this->assertNotEmpty($request->json('results'));
    }

    /** @test */
    public function itReturnsPartialResults(): void
    {
        foreach (['span', 'ish', 'spanis', 'ani'] as $term) {
            $request = $this->makeRequest($term);

            $this->assertNotEmpty($request->json('results'));
        }
    }

    /** @test */
    public function itReturnsTheCorrectSearchData(): void
    {
        $request = $this->makeRequest('spanish');

        $request->assertJsonStructure([
            'results' => [
                '*' => [
                    'id',
                    'term',
                    'type',
                ],
            ],
        ]);
    }

    /** @test */
    public function itHighlightsTheSearchString(): void
    {
        $request = $this->makeRequest('span');
        $firstResult = $request->json('results.0');

        $this->assertEquals('<strong>span</strong>ish', $firstResult['term']);
    }

    /** @test */
    public function itLogsTheSearch(): void
    {
        $this->assertEmpty(TravelCardSearchTermHistory::all());

        $this->makeRequest('spain');

        $this->assertNotEmpty(TravelCardSearchTermHistory::all());
    }

    /** @test */
    public function itIncrementsTheTermHistoryHits()
    {
        $this->makeRequest('spain');

        $this->assertEquals(1, TravelCardSearchTermHistory::first()->hits);
    }

    /** @test */
    public function itResusesAnExistingTermHistory()
    {
        $this->makeRequest('spain');

        $this->assertCount(1, TravelCardSearchTermHistory::all());
        $this->assertEquals(1, TravelCardSearchTermHistory::first()->hits);

        $this->makeRequest('spain');

        $this->assertCount(1, TravelCardSearchTermHistory::all());
        $this->assertEquals(2, TravelCardSearchTermHistory::first()->hits);
    }

    /** @test */
    public function itReturnsNotFoundWhenGettingInfo(): void
    {
        $this->get('api/shop/travel-card-search/999')->assertNotFound();
    }

    /** @test */
    public function itReturnsOkInfoWithASearchTerm(): void
    {
        $this->get('api/shop/travel-card-search/1')->assertOk();
    }

    /** @test */
    public function itReturnsTheSearchTermInfo(): void
    {
        $this->get('api/shop/travel-card-search/1')
            ->assertJsonStructure([
                'term',
                'type',
                'products' => [
                    '*' => [
                        'title',
                        'link',
                        'price',
                        'image',
                        'category',
                    ],
                ],
            ]);
    }

    /** @test */
    public function itIncrementsTheHitsCountWhenSelectingATerm()
    {
        $this->assertEquals(0, TravelCardSearchTerm::query()->first()->hits);

        $this->get('api/shop/travel-card-search/1');

        $this->assertEquals(1, TravelCardSearchTerm::query()->first()->hits);
    }
}
