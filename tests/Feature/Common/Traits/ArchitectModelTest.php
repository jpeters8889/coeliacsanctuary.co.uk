<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Traits;

use Tests\TestCase;
use Spatie\TestTime\TestTime;
use Coeliac\Common\Models\Image;
use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Support\Facades\Cache;

class ArchitectModelTest extends TestCase
{
    private Blog $blog;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->actingAs(admin_user());

        $this->post('/cs-adm/api/blueprints/submit', [
            '_blueprint' => 'blog',
            '_state' => 'add',
            'title' => 'Foo Title',
            'description' => 'Foo Description',
            'live' => true,
            'meta_tags' => 'foo',
            'meta_description' => 'foo',
            'blog_tags' => 'foo,bar',
            'Images' => json_encode([
                'article' => ['_test_image.png', '_test_image_2.png', '_test_image_3.png'],
            ]),
            'architect_body' => 'Foo Bar <article-image src="_test_image.png"></article-image><article-image src="_test_image_2.png"></article-image><article-image src="_test_image_3.png"></article-image>',
        ]);

        $this->blog = Blog::query()->first();

        TestTime::freeze()->addMinute();
    }

    /** @test */
    public function itCreatesAModel()
    {
        $this->assertCount(1, Blog::all());
    }

    /** @test */
    public function itCreatesASlug()
    {
        $this->assertNotNull($this->blog->slug);
        $this->assertEquals('foo-title', $this->blog->slug);
    }

    /** @test */
    public function itChangesTheImagesToTheFullUrlWhenTheImageIsInTheBody()
    {
        Image::query()->get()->each(function (Image $image) {
            $this->assertStringContainsString($image->image_url, $this->blog->body);
        });
    }

    /** @test */
    public function itOnlyUsesTheImageNameWhenEditing()
    {
        Image::query()->get()->each(function (Image $image) {
            $this->assertStringContainsString($image->file_name, $this->blog->architect_body);
            $this->assertStringNotContainsString($image->image_url, $this->blog->architect_body);
        });
    }

    /** @test */
    public function itUpdatesTheBodyFieldWithTheUpdatedImages()
    {
        Image::query()->get()->each(function (Image $image, $index) {
            $filename = '_test_image.png';

            if ($index > 0) {
                $x = $index + 1;
                $filename = "_test_image_{$x}.png";
            }

            $image->update(['file_name' => $filename]);
        });

        Cache::forget('blogs-1-images-saved');

        $this->post('/cs-adm/api/blueprints/submit', [
            '_blueprint' => 'blog',
            '_state' => 'update',
            '_id' => 1,
            'title' => 'Foo Title',
            'description' => 'Foo Description',
            'live' => true,
            'meta_tags' => 'foo',
            'meta_description' => 'foo',
            'blog_tags' => 'foo,bar',
            'Images' => json_encode([
                'article' => ['_test_image.png', '_test_image_2.png', '_test_image_3.png'],
            ]),
            'architect_body' => 'Foo Bar <article-image src="_test_image.png"></article-image><article-image src="_test_image_2.png"></article-image><article-image src="_test_image_3.png"></article-image>',
        ]);

        $this->blog->refresh();

        Image::query()->get()->each(function (Image $image) {
            $this->assertStringContainsString('<article-image src="'.$image->image_url.'">', $this->blog->body);
        });
    }
}
