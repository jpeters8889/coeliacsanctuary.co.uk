<?php

declare(strict_types=1);

namespace Tests\Architect;

use Coeliac\Architect\Plans\TagManager\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JPeters\Architect\TestHelpers\Abstracts\PlanTestCase;
use JPeters\Architect\TestHelpers\Laravel\Models\Blog;

class TagManagerPlanTest extends PlanTestCase
{
    public function getPlan()
    {
        return Plan::class;
    }

    public function getColumnName()
    {
        return 'blog_tags';
    }

    /** @test */
    public function it_updates_the_model()
    {
        $blog = factory(Blog::class)->create();

        $class = $this->getPlan();

        /** @var Plan $plan */
        $plan = new $class('blog_tags');

        $tags = 'foo,bar,baz';

        $plan->handleUpdate($blog, 'blog_tags', $tags);

        $this->assertNotEmpty($blog->tags());

        $this->assertCount(3, $blog->tags);

        foreach (explode(',', $tags) as $tag) {
            $this->assertTrue($blog->tags()->where('tag', $tag)->exists());
        }
    }

    /** @test */
    public function it_gets_the_current_value()
    {
        $blog = factory(Blog::class)->create();

        $class = $this->getPlan();

        /** @var Plan $plan */
        $plan = new $class('blog_tags');

        $tags = 'foo,bar,baz';

        $plan->handleUpdate($blog, 'blog_tags', $tags);

        $this->assertEquals($tags, $plan->getCurrentValue($blog));
    }

    /** @test */
    public function it_tag_source_is_listed_in_the_metas()
    {
        $this->assertArrayHasKey('tagSource', $this->plan->getMetas());
    }

    /** @test */
    public function the_tag_source_can_be_specified()
    {
        $this->assertNull($this->plan->getMetas()['tagSource']);

        $this->plan->useTagSource('foo');

        $this->assertEquals('foo', $this->plan->getMetas()['tagSource']);
    }
}
