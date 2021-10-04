<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Comments;

use Tests\TestCase;
use Coeliac\Common\Models\Comment;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Common\Models\CommentReply;

class CommentsTest extends TestCase
{
    /** @test */
    public function itIsNotApprovedByDefault()
    {
        $comment = $this->build(Comment::class)
            ->on($this->create(Blog::class))
            ->create();

        $this->assertFalse($comment->approved);
    }

    /** @test */
    public function itCanBeRepliedTo()
    {
        $comment = $this->build(Comment::class)
            ->on($this->create(Blog::class))
            ->create();

        $this->build(CommentReply::class)
            ->on($comment)
            ->create();

        $this->assertEquals(1, $comment->reply->fresh()->count());
    }
}
