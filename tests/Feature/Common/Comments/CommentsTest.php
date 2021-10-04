<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Comments;

use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Models\BlogTag;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Tests\Traits\CreatesBlogs;
use Coeliac\Common\Models\Image;
use Coeliac\Common\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;

class CommentsTest extends TestCase
{
    use HasImages;
    use WithFaker;

    private $blog;

    public function setUp(): void
    {
        parent::setUp();

        $this->blog = $this->build(Blog::class)
            ->has($this->build(BlogTag::class), 'tags')
            ->create()
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL);
    }

    /** @test */
    public function itRejectsCommentsWithAnIncorrectType()
    {
        $this->post('api/comments', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'comment' => $this->faker->sentence,
            'id' => 1,
            'area' => 'foo',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['area']);
    }

    /** @test */
    public function itRejectsCommentsWithoutAArea()
    {
        $this->post('api/comments', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'comment' => $this->faker->sentence,
            'id' => '1',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['area']);
    }

    /** @test */
    public function itRejectsCommentsWithoutAnId()
    {
        $this->post('api/comments', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'comment' => $this->faker->sentence,
            'area' => 'blog',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['id']);
    }

    /** @test */
    public function itRejectsCommentsWithoutAnName()
    {
        $this->post('api/comments', [
            'email' => $this->faker->email,
            'comment' => $this->faker->sentence,
            'id' => 1,
            'area' => 'blog',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function itRejectsCommentsWithoutAnEmail()
    {
        $this->post('api/comments', [
            'name' => $this->faker->name,
            'comment' => $this->faker->sentence,
            'id' => 1,
            'area' => 'blog',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function itRejectsCommentsWithoutAComment()
    {
        $this->post('api/comments', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'id' => 1,
            'area' => 'blog',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['comment']);
    }

    /** @test */
    public function itCreatesCommentsThatAreHiddenByDefault()
    {
        $params = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'comment' => $this->faker->sentence,
            'id' => '1',
            'area' => 'blog',
        ];

        $this->post('api/comments', $params)->assertStatus(200);

        $this->assertDatabaseHas('comments', [
            'name' => $params['name'],
            'email' => $params['email'],
            'comment' => $params['comment'],
        ]);

        $comment = Comment::first();

        $this->assertEquals(0, $comment->approved);

        $request = $this->get('/api/comments/blog/' . $this->blog->id);

        $request->assertDontSee($params['name']);
        $request->assertDontSee($params['comment']);
    }

    /** @test */
    public function itCanBeApproved()
    {
        $params = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'comment' => $this->faker->sentence,
            'id' => '1',
            'area' => 'blog',
        ];

        $this->post('api/comments', $params)->assertSuccessful();

        $comment = Comment::query()->first();

        $comment->approved = true;
        $comment->save();

        $this->assertEquals(1, $comment->approved);

        $request = $this->get('/api/comments/blog/' . $this->blog->id);

        $request->assertSee($params['name'], false);
        $request->assertSee($params['comment'], false);
    }
}
