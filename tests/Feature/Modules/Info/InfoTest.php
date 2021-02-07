<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Info;

use Tests\TestCase;
use Coeliac\Common\Models\Accordion;
use Coeliac\Common\Models\AccordionType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InfoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function itLoadsTheInfoIndexPage()
    {
        $this->get('info')
            ->assertStatus(200)
            ->assertSee('Coeliac Information', false)
            ->assertSee('Shopping List', false)
            ->assertSee('Storecupboard Checklist', false)
            ->assertSee('Gluten Challenge', false);
    }

    /** @test */
    public function itLoadsTheCoeliacInfoPage()
    {
        $question = factory(Accordion::class)->create(['accordion_type_id' => AccordionType::COELIAC_INFO]);

        $this->get('info/coeliac')
            ->assertStatus(200)
            ->assertSee($question->title, false)
            ->assertSee($question->body, false);
    }

    /** @test */
    public function itLoadsTheShoppingListPage()
    {
        $this->get('info/shopping-list')->assertStatus(200);
    }

    /** @test */
    public function itLoadsTheStorecupboardPage()
    {
        $this->get('info/storecupboard-check')->assertStatus(200);
    }

    /** @test */
    public function itLoadsTheGlutenChallengePage()
    {
        $this->get('info/gluten-challenge')->assertStatus(200);
    }
}