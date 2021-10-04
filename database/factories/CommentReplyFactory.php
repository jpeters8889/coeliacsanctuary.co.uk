<?php

namespace Database\Factories;

use Coeliac\Common\Models\Comment;
use Coeliac\Common\Models\CommentReply;

class CommentReplyFactory extends Factory
{
    protected $model = CommentReply::class;

    public function definition()
    {
        return [
            'comment_reply' => $this->faker->paragraph,
        ];
    }

    public function on(Comment $comment)
    {
        return $this->state(fn (array $attributes) => [
           'comment_id' => $comment->id,
        ]);
    }
}
