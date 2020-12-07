<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Coeliac\Common\Models\Image;
use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArchitectModelTest extends TestCase
{
    use RefreshDatabase;

    private Blog $blog;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->createAdminUser();
        $this->actingAs(admin_user());

        $this->withoutExceptionHandling();

        $request = $this->post('/cs-adm/api/blueprints/submit', [
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
    }

    /** @test */
    public function it_creates_a_model()
    {
        $this->assertCount(1, Blog::all());
    }

    /** @test */
    public function it_creates_a_slug()
    {
        $this->assertNotNull($this->blog->slug);
        $this->assertEquals('foo-title', $this->blog->slug);
    }

    /** @test */
    public function it_changes_the_images_to_the_full_url_when_the_image_is_in_the_body()
    {
        Image::query()->get()->each(function (Image $image) {
            $this->assertStringContainsString($image->image_url, $this->blog->body);
        });
    }

    /** @test */
    public function it_only_uses_the_image_name_when_editing()
    {
        Image::query()->get()->each(function (Image $image) {
            $this->assertStringContainsString($image->file_name, $this->blog->architect_body);
            $this->assertStringNotContainsString($image->image_url, $this->blog->architect_body);
        });
    }

    /** @test */
    public function it_updates_the_body_field_with_the_updated_images()
    {
        Image::query()->get()->each(function (Image $image, $index) {
            $filename = '_test_image.png';

            if ($index > 0) {
                $x = $index + 1;
                $filename = "_test_image_{$x}.png";
            }

            $image->update(['file_name' => $filename]);
        });

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
