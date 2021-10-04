<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Info;

use Tests\TestCase;
use Coeliac\Common\Models\Accordion;
use Coeliac\Common\Models\AccordionType;

class InfoTest extends TestCase
{
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
        $question = $this->build(Accordion::class)
            ->info()
            ->create();

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
