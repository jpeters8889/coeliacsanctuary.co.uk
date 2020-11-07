<?php

namespace Tests\Feature;

use Coeliac\Common\Models\Image;
use Tests\TestCase;
use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArchitectModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_changes_the_images_to_the_full_url_when_the_image_is_in_the_body()
    {
        $this->createAdminUser();
        $this->actingAs(admin_user());

        $this->withoutExceptionHandling();

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
                'article' => ['_test_image.png'],
            ]),
            'architect_body' => 'Foo Bar <article-image src="_test_image.png"></article-image>',
        ]);

        $this->assertCount(1, Blog::all());

        /** @var Blog $blog */
        $blog = Blog::query()->first();
        $image = $blog->first_image;

        $this->assertEquals('Foo Title', $blog->title);
        $this->assertStringContainsString($image, $blog->body);

        /** @var Image $imageRow */
        $imageRow = Image::query()->first();

        $this->assertStringContainsString($imageRow->file_name, $blog->architect_body);
        $this->assertStringNotContainsString($imageRow->image_url, $blog->architect_body);
    }
}
