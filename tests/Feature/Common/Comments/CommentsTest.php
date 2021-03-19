<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Comments;

use Tests\TestCase;
use Tests\Traits\HasImages;
use Tests\Traits\CreatesBlogs;
use Coeliac\Common\Models\Image;
use Coeliac\Common\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsTest extends TestCase
{
    use CreatesBlogs;
    use HasImages;
    use RefreshDatabase;
    use WithFaker;

    private $blog;

    public function setUp(): void
    {
        parent::setUp();

        $this->blog = $this->createBlog()
        ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER)
        ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL);

        $this->blog->tags()->attach($this->createBlogTag());
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
        $response = $this->post('api/comments', [
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
        $response = $this->post('api/comments', [
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
        $response = $this->post('api/comments', [
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

        $request = $this->get('/api/comments/blog/'.$this->blog->id);

        $request->assertDontSee($params['name']);
        $request->assertDontSee($params['comment']);
    }

    /** @test */
    public function itCanBeApproved()
    {
        $this->withoutExceptionHandling();
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

        $request = $this->get('/api/comments/blog/'.$this->blog->id);

        $request->assertSee($params['name'], false);
        $request->assertSee($params['comment'], false);
    }
}
