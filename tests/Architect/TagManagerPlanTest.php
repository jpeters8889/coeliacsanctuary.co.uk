<?php

declare(strict_types=1);

namespace Tests\Architect;

use Coeliac\Architect\Plans\TagManager\Plan;
use JPeters\Architect\TestHelpers\Laravel\Models\Blog;
use JPeters\Architect\TestHelpers\Abstracts\PlanTestCase;

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
    public function itUpdatesTheModel()
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
    public function itGetsTheCurrentValue()
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
    public function itTagSourceIsListedInTheMetas()
    {
        $this->assertArrayHasKey('tagSource', $this->plan->getMetas());
    }

    /** @test */
    public function theTagSourceCanBeSpecified()
    {
        $this->assertNull($this->plan->getMetas()['tagSource']);

        $this->plan->useTagSource('foo');

        $this->assertEquals('foo', $this->plan->getMetas()['tagSource']);
    }
}
