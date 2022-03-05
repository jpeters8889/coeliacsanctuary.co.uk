<?php

namespace Tests\Feature\Modules\EatingOut\WhereToEat;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Tests\TestCase;

class WhereToEatDetailsTest extends TestCase
{
    protected WhereToEat $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eatery = $this->create(WhereToEat::class);
    }

    /** @test */
    public function itReturns404IfAPlaceDoesntExist(): void
    {
        $this->get('/wheretoeat/foo/bar/baz')->assertNotFound();
    }

    /** @test */
    public function itReturns404IfAPlaceIsntLive(): void
    {
        $this->eatery->update(['live' => false]);

        $this->get($this->eatery->link())->assertNotFound();
    }

    /** @test */
    public function itReturns404WhenTryingToGetAValidEateryInAWrongCounty(): void
    {
        $this->get('/' . implode('/wheretoeat/', [
                'foobarbaz',
                $this->eatery->town->slug,
                $this->eatery->slug,
            ]))->assertNotFound();
    }

    /** @test */
    public function itReturns404WhenTryingToGetAValidEateryInAWrongTown(): void
    {
        $this->get('/wheretoeat/' . implode('/', [
                $this->eatery->county->slug,
                'foobarbaz',
                $this->eatery->slug,
            ]))->assertNotFound();
    }

    /** @test */
    public function itReturnsOkWithAValidUrl(): void
    {
        $this->get($this->eatery->link())->assertOk();
    }
}
