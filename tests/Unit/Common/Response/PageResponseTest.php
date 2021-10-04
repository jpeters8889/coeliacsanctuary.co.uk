<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Response;

use Tests\TestCase;
use Coeliac\Common\Response\Page;
use Illuminate\Container\Container;
use Coeliac\Common\Models\Announcement;

class PageResponseTest extends TestCase
{
    protected Page $page;

    protected function setUp(): void
    {
        parent::setUp();

        $this->page = Container::getInstance()->make(Page::class);
    }

    /** @test */
    public function itHasBreadcrumbs()
    {
        $this->assertArrayHasKey('breadcrumbs', $this->getPageData());
        $this->assertIsArray($breadcrumbs = $this->getPageData()['breadcrumbs']);

        foreach (['crumbs', 'location'] as $key) {
            $this->assertArrayHasKey($key, $breadcrumbs);
        }

        $this->assertIsArray($breadcrumbs['crumbs']);

        foreach (['link', 'title'] as $key) {
            foreach ($breadcrumbs['crumbs'] as $crumb) {
                $this->assertArrayHasKey($key, $crumb);
            }
        }

        $this->assertEquals('/', $breadcrumbs['crumbs'][0]['link']);
        $this->assertEquals('Coeliac Sanctuary', $breadcrumbs['crumbs'][0]['title']);
    }

    /** @test */
    public function itCanHaveBreadcrumbsAdded()
    {
        $this->page->breadcrumbs([
            ['link' => 'foo', 'title' => 'bar'],
        ], 'baz');

        $this->assertCount(2, $crumbs = $this->getPageData()['breadcrumbs']['crumbs']);

        foreach (['link', 'title'] as $key) {
            foreach ($crumbs as $crumb) {
                $this->assertArrayHasKey($key, $crumb);
            }
        }

        $this->assertEquals('foo', $crumbs[1]['link']);
        $this->assertEquals('bar', $crumbs[1]['title']);
        $this->assertEquals('baz', $this->getPageData()['breadcrumbs']['location']);
    }

    /** @test */
    public function itHasPrefetchInformation()
    {
        $this->assertArrayHasKey('prefetch', $this->getPageData());
        $this->assertIsArray($this->getPageData()['prefetch']);

        $this->page->addPrefetch(['foo' => 'bar']);

        $this->assertArrayHas('foo', 'bar', $this->getPageData()['prefetch']);
    }

    /** @test */
    public function itCanHaveSearchTrackingDisabled()
    {
        $this->assertArrayHasKey('tracking', $this->getPageData());
        $this->assertTrue($this->getPageData()['tracking']);

        $this->page->doNotIndex();

        $this->assertFalse($this->getPageData()['tracking']);
    }

    /** @test */
    public function itHasSiteAnnouncements()
    {
        $this->assertArrayHasKey('announcements', $this->getPageData());
        $this->assertEmpty($this->getPageData()['announcements']);

        $this->create(Announcement::class);

        $this->assertNotEmpty($this->getPageData()['announcements']);
    }

    /** @test */
    public function itKnowsWhetherItCanBeAddedToTheScrapbook()
    {
        $this->assertArrayHasKey('scrapable', $this->getPageData());
        $this->assertFalse($this->getPageData()['scrapable']);

        $this->page->scrapable('blog', 1);

        $this->assertNotFalse($this->getPageData()['scrapable']);
    }

    /** @test */
    public function itReturnsTheScrapableInformation()
    {
        $this->page->scrapable('blog', 1);

        $this->assertIsArray($data = $this->getPageData()['scrapable']);

        foreach (['area', 'id'] as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    protected function getPageData(?Page $page = null)
    {
        if (!$page) {
            $page = $this->page;
        }

        return $page->render('static.test')->original->getData();
    }
}
