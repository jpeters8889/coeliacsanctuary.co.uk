<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\WhereToEat;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Illuminate\Support\Str;
use Tests\TestCase;

class WhereToEatSlugifyTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        WhereToEat::unsetEventDispatcher();
    }

    /** @test */
    public function itAsksForConfirmation(): void
    {
        $this->artisan('coeliac:slugify-eateries')
            ->expectsConfirmation('Are you sure you want to slugify all eateries?');
    }

    /** @test */
    public function itDoesntUpdateRowsWhenNotConfirmed(): void
    {
        $eatery = $this->create(WhereToEat::class);

        $this->artisan('coeliac:slugify-eateries')
            ->expectsConfirmation('Are you sure you want to slugify all eateries?')
            ->assertExitCode(0);

        $this->assertTrue($eatery->is($eatery->fresh()));
    }

    /** @test */
    public function itDoesntCreateASlugWhenNotRunningInProductionMode(): void
    {
        $eatery = $this->build(WhereToEat::class)
            ->withOutSlug()
            ->create(['name' => 'My Special Eating Location']);

        $this->assertNull($eatery->slug);

        $this->artisan('coeliac:slugify-eateries')
            ->expectsConfirmation('Are you sure you want to slugify all eateries?');

        $this->assertTrue($eatery->is($eatery->fresh()));
    }

    /** @test */
    public function itSetsASlugWhenRunningInProductionMode(): void
    {
        $this->withoutEvents();

        $eatery = $this->build(WhereToEat::class)
            ->withOutSlug()
            ->create([
                'name' => $slug = 'My Special Eating Location',
                'country_id' => 2,
            ]);

        $this->assertNull($eatery->slug);

        $this->artisan('coeliac:slugify-eateries')
            ->expectsConfirmation('Are you sure you want to slugify all eateries?', 'yes');

        $eatery->refresh();

        $this->assertNotNull($eatery->slug);
        $this->assertEquals(Str::slug($slug), $eatery->slug);
    }

    /** @test */
    public function itWillUseTheSameSlugForDifferentTowns()
    {
        $this->withoutEvents();

        $this->create(WhereToEatTown::class);

        [$eatery, $eatery2] = $this->build(WhereToEat::class)
            ->state([
                'slug' => null,
                'name' => $slug = 'My Special Eating Location',
                'country_id' => 2,
            ])
            ->sequence(fn ($sequence) => ['town_id' => $sequence->index + 1])
            ->count(2)
            ->create();

        $this->artisan('coeliac:slugify-eateries')
            ->expectsConfirmation('Are you sure you want to slugify all eateries?', 'yes');

        $eatery->refresh();
        $eatery2->refresh();

        $this->assertEquals(Str::slug($slug), $eatery->slug);
        $this->assertEquals(Str::slug($slug), $eatery2->slug);
    }

    /** @test */
    public function itWillSuffixThePostcodeIfAPlaceNameIsUsedTwiceInOneTown(): void
    {
        $this->withoutEvents();

        $this->create(WhereToEatTown::class);

        [$eatery, $eatery2] = $this->build(WhereToEat::class)
            ->state([
                'slug' => null,
                'name' => $slug = 'My Special Eating Location',
                'country_id' => 2,
            ])
            ->sequence(fn ($sequence) => ['address' => implode('<br />', [
                '123 Fake Street',
                'AB1 ' . $sequence->index . 'CD',
            ])])
            ->count(2)
            ->create();

        $this->artisan('coeliac:slugify-eateries')
            ->expectsConfirmation('Are you sure you want to slugify all eateries?', 'yes');

        $eatery->refresh();
        $eatery2->refresh();

        $this->assertEquals(Str::of($slug)->append(' AB1 0CD')->slug()->toString(), $eatery->slug);
        $this->assertEquals(Str::of($slug)->append(' AB1 1CD')->slug()->toString(), $eatery2->slug);
    }
}
