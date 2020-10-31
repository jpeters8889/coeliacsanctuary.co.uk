<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use Coeliac\Common\Models\Comment;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Common\Models\CommentReply;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_is_not_approved_by_default()
    {
        $blog = factory(Blog::class)->create();

        $comment = factory(Comment::class)->create([
            'commentable_id' => $blog->id,
            'commentable_type' => Blog::class,
        ]);

        $this->assertFalse($comment->approved);
    }

    /** @test */
    public function it_can_be_replied_to()
    {
        $blog = factory(Blog::class)->create();

        $comment = factory(Comment::class)->create([
            'commentable_id' => $blog->id,
            'commentable_type' => Blog::class,
            'approved' => true,
        ]);

        $comment->reply()->save(factory(CommentReply::class)->create(['comment_id' => $comment->id]));

        $this->assertEquals(1, $comment->reply->count());
    }
}
